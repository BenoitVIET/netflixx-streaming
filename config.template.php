<?php
/**
 * Configuration NetflixX - TEMPLATE
 * Copiez ce fichier vers config.php et modifiez vos paramètres
 */

// Démarrer la session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Configuration de la base de données - MODIFIEZ CES VALEURS
$host = 'localhost';
$dbname = 'VOTRE_NOM_DE_BASE'; 
$username = 'VOTRE_USER';       
$password = 'VOTRE_PASSWORD';   

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// ========================================
// FONCTIONS DE SESSION ET AUTHENTIFICATION
// ========================================

function estConnecte() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

function obtenirUtilisateur() {
    return isset($_SESSION['user_login']) ? $_SESSION['user_login'] : null;
}

function loginExiste($login) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM user WHERE login = :login");
    $stmt->bindParam(':login', $login);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['count'] > 0;
}

function creerUtilisateur($login, $password) {
    global $pdo;
    try {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO user (login, password) VALUES (:login, :password)");
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':password', $password_hash);
        return $stmt->execute();
    } catch (PDOException $e) {
        return false;
    }
}

function connecterUtilisateur($login, $password) {
    global $pdo;
    try {
        $stmt = $pdo->prepare("SELECT id, password FROM user WHERE login = :login");
        $stmt->bindParam(':login', $login);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_login'] = $login;
            return true;
        }
        return false;
    } catch (PDOException $e) {
        return false;
    }
}

// ========================================
// FONCTIONS DE GESTION DES FILMS
// ========================================

function obtenirDerniersFilms($limite = 5) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT id, title, description, urlphoto FROM film ORDER BY id DESC LIMIT :limite");
    $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function obtenirTousLesFilms() {
    global $pdo;
    $stmt = $pdo->prepare("SELECT id, title, description, urlphoto FROM film ORDER BY title ASC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function obtenirFilmParId($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM film WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function ajouterFilm($title, $description, $urlphoto = '', $urlvideo = '') {
    global $pdo;
    
    try {
        // Validation et nettoyage des données
        $title = trim($title);
        $description = trim($description);
        
        if (strlen($title) > 255) {
            error_log("Erreur ajout film: Titre trop long (" . strlen($title) . " caractères)");
            return false;
        }
        
        if (strlen($description) > 255) {
            $description = substr($description, 0, 252) . '...';
            error_log("Description tronquée automatiquement à 255 caractères");
        }
        
        if (strlen($urlphoto) > 255) {
            error_log("Erreur ajout film: URL photo trop longue (" . strlen($urlphoto) . " caractères)");
            return false;
        }
        
        $stmt = $pdo->prepare("INSERT INTO film (title, description, urlphoto, urlvideo) VALUES (:title, :description, :urlphoto, :urlvideo)");
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':urlphoto', $urlphoto);
        $stmt->bindParam(':urlvideo', $urlvideo);
        
        $result = $stmt->execute();
        
        if (!$result) {
            $errorInfo = $stmt->errorInfo();
            error_log("Erreur SQL ajout film: " . print_r($errorInfo, true));
        }
        
        return $result;
    } catch (PDOException $e) {
        error_log("Exception PDO ajout film: " . $e->getMessage());
        return false;
    }
}

// ========================================
// FONCTIONS D'UPLOAD D'IMAGE
// ========================================

function uploadImage($file) {
    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
        return ['error' => 'Aucun fichier uploadé ou erreur d\'upload'];
    }
    
    $extensions_autorisees = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    $taille_max = 5 * 1024 * 1024; // 5MB
    
    $nom_fichier = $file['name'];
    $taille_fichier = $file['size'];
    $tmp_name = $file['tmp_name'];
    
    if ($taille_fichier > $taille_max) {
        return ['error' => 'Le fichier est trop volumineux (max 5MB)'];
    }
    
    $extension = strtolower(pathinfo($nom_fichier, PATHINFO_EXTENSION));
    if (!in_array($extension, $extensions_autorisees)) {
        return ['error' => 'Extension non autorisée. Utilisez: ' . implode(', ', $extensions_autorisees)];
    }
    
    // Validation MIME pour la sécurité
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime_type = finfo_file($finfo, $tmp_name);
    finfo_close($finfo);
    
    $mimes_autorises = [
        'image/jpeg',
        'image/jpg', 
        'image/png',
        'image/gif',
        'image/webp'
    ];
    
    if (!in_array($mime_type, $mimes_autorises)) {
        return ['error' => 'Type MIME invalide. Seules les vraies images sont autorisées.'];
    }
    
    $dossier_destination = 'uploads/images/';
    if (!is_dir($dossier_destination)) {
        mkdir($dossier_destination, 0777, true);
    }
    
    $nom_unique = uniqid() . '_' . time() . '.' . $extension;
    $chemin_destination = $dossier_destination . $nom_unique;
    
    if (move_uploaded_file($tmp_name, $chemin_destination)) {
        return ['chemin' => $chemin_destination];
    } else {
        return ['error' => 'Erreur lors de l\'upload du fichier'];
    }
}

// ========================================
// FONCTIONS UTILITAIRES D'AFFICHAGE
// ========================================

function nettoyer($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

function titreMajuscules($titre) {
    return strtoupper($titre);
}

// ========================================
// FONCTIONS VIDÉO
// ========================================

function obtenirBonneVideo($film_id, $titre) {
    // Correspondance titre/vidéo avec URLs YouTube
    $videos_correctes = [
        'Avatar' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/5PSNL1qE6VY" title="Avatar Official Trailer" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>',
        'Titanic' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/I7c1etV7D7g" title="Titanic Official Trailer" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>',
        // Ajoutez vos vidéos ici...
    ];
    
    return isset($videos_correctes[$titre]) ? $videos_correctes[$titre] : null;
}

// ========================================
// ALIASES POUR COMPATIBILITÉ
// ========================================

function getDerniers5Films() {
    return obtenirDerniersFilms(5);
}

function getTousLesFilms() {
    return obtenirTousLesFilms();
}

function getFilmParId($id) {
    return obtenirFilmParId($id);
}
?>