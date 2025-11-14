<?php
require_once 'config.php';

// Vérifier si l'utilisateur est connecté
if (!estConnecte()) {
    // Si pas connecté, rediriger vers la page d'accueil
    header('Location: index.php');
    exit;
}

// Détruire toutes les données de session
$_SESSION = array();

// Détruire le cookie de session si il existe
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Détruire la session
session_destroy();

// Message de confirmation et redirection
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Déconnexion - NetflixX</title>
    
    <!-- Redirection automatique après 3 secondes -->
    <meta http-equiv="refresh" content="3;url=index.php">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="logout-container">
        <div class="logout-icon">👋</div>
        <h1>Déconnexion réussie</h1>
        <p>Vous avez été déconnecté avec succès.<br>
        Vous allez être redirigé vers la page d'accueil...</p>
        <a href="index.php" class="btn btn-home">🏠 Retour à l'accueil</a>
    </div>
</body>
</html>