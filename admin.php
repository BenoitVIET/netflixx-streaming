<?php
require_once 'config.php';

// Vérifier que l'utilisateur est connecté, sinon rediriger vers connexion
if (!estConnecte()) {
    header('Location: connexion.php');
    exit;
}

// Variables pour le formulaire
$message = '';
$message_type = '';

// Traitement du formulaire d'ajout de film
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $urlvideo = trim($_POST['urlvideo'] ?? '');
    $urlphoto = '';  // Sera défini par l'upload
    
    // Validation des données
    if (empty($title)) {
        $message = 'Le titre du film est obligatoire.';
        $message_type = 'error';
    } elseif (empty($description)) {
        $message = 'La description du film est obligatoire.';
        $message_type = 'error';
    } else {
        // Gestion de l'upload d'image
        $upload_result = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
            $upload_result = uploadImage($_FILES['image']);
            
            if (isset($upload_result['error'])) {
                $message = 'Erreur image : ' . $upload_result['error'];
                $message_type = 'error';
            } else {
                $urlphoto = $upload_result['chemin'];
            }
        }
        
        // Si pas d'erreur d'upload, ajouter le film
        if (!isset($upload_result['error'])) {
            if (ajouterFilm($title, $description, $urlphoto, $urlvideo)) {
                $message = 'Film ajouté avec succès !';
                $message_type = 'success';
                
                // Réinitialiser les champs après succès
                $title = $description = $urlvideo = '';
            } else {
                $message = 'Erreur lors de l\'ajout du film. Veuillez réessayer.';
                $message_type = 'error';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Ajouter un film - NetflixX</title>
    
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Menu de navigation -->
    <div class="top-menu">
        <strong>NetflixX</strong>
        <a href="index.php">🏠 Accueil</a>
        <a href="films.php">🎬 Films</a>
        <a href="admin.php" class="active">⚙️ Admin</a>
        <span style="margin-left: 20px;">👤 <?php echo nettoyer(obtenirUtilisateur()); ?></span>
        <a href="deconnexion.php">🚪 Déconnexion</a>
    </div>

    <div class="container">
        <!-- En-tête admin -->
        <header class="admin-header">
            <h1 class="admin-title">⚙️ Espace Administrateur</h1>
            <p class="admin-subtitle">Gérez le catalogue de films NetflixX</p>
        </header>

        <!-- Info utilisateur connecté -->
        <div class="user-info">
            🔐 Connecté en tant que : <strong><?php echo nettoyer(obtenirUtilisateur()); ?></strong>
        </div>

        <!-- Formulaire d'ajout de film -->
        <main class="admin-card">
            <h2 class="form-title">🎬 Ajouter un nouveau film</h2>

            <!-- Message de feedback -->
            <?php if (!empty($message)): ?>
                <div class="message <?php echo $message_type; ?>">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <!-- Informations -->
            <div class="form-info">
                <strong>ℹ️ Instructions :</strong><br>
                • Le titre et la description sont obligatoires<br>
                • Vous pouvez uploader une image (JPG, PNG, GIF, WebP - max 5MB)<br>
                • L'URL vidéo peut contenir un code iframe YouTube<br>
                • Tous les champs seront affichés sur le site
            </div>

            <!-- Formulaire -->
            <form method="POST" action="admin.php" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="title" class="form-label">
                        🎬 Titre du film <span class="required">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="title" 
                        name="title" 
                        class="form-input"
                        value="<?php echo htmlspecialchars($title ?? ''); ?>"
                        placeholder="Ex: Avengers: Endgame"
                        required
                        maxlength="255"
                    >
                </div>

                <div class="form-group">
                    <label for="description" class="form-label">
                        📝 Description <span class="required">*</span>
                        <small style="color: #666;">(Maximum 255 caractères)</small>
                    </label>
                    <textarea 
                        id="description" 
                        name="description" 
                        class="form-textarea"
                        placeholder="Décrivez l'intrigue du film..."
                        required
                        maxlength="255"
                        oninput="updateCharCount(this)"
                    ><?php echo htmlspecialchars($description ?? ''); ?></textarea>
                    <small id="charCount" style="color: #666; float: right;">0/255 caractères</small>
                    <div style="clear: both;"></div>
                </div>

                <div class="form-group">
                    <label for="image" class="form-label">
                        🖼️ Image/Affiche du film
                    </label>
                    <input 
                        type="file" 
                        id="image" 
                        name="image" 
                        class="form-input"
                        accept=".jpg,.jpeg,.png,.gif,.webp"
                    >
                    <small style="color: #666; font-size: 0.9rem;">
                        Formats acceptés : JPG, PNG, GIF, WebP (max 5MB)
                    </small>
                </div>

                <div class="form-group">
                    <label for="urlvideo" class="form-label">
                        🎥 Code iframe YouTube (optionnel)
                    </label>
                    <textarea 
                        id="urlvideo" 
                        name="urlvideo" 
                        class="form-textarea"
                        placeholder="<iframe src=&quot;https://www.youtube.com/embed/...&quot;>...</iframe>"
                    ><?php echo htmlspecialchars($urlvideo ?? ''); ?></textarea>
                </div>

                <button type="submit" class="submit-btn">
                    ✨ Ajouter le film
                </button>
            </form>

            <!-- Actions supplémentaires -->
            <div class="actions-section">
                <a href="films.php" class="action-btn">
                    📋 Voir tous les films
                </a>
                <a href="index.php" class="action-btn">
                    🏠 Retour à l'accueil
                </a>
            </div>
        </main>
    </div>

    <script>
    function updateCharCount(textarea) {
        const charCount = document.getElementById('charCount');
        const currentLength = textarea.value.length;
        const maxLength = 255;
        
        charCount.textContent = currentLength + '/' + maxLength + ' caractères';
        
        if (currentLength > maxLength - 20) {
            charCount.style.color = '#e50914'; // Rouge NetflixX
        } else {
            charCount.style.color = '#666';
        }
    }
    
    // Initialiser le compteur au chargement de la page
    document.addEventListener('DOMContentLoaded', function() {
        const textarea = document.getElementById('description');
        if (textarea) {
            updateCharCount(textarea);
        }
    });
    </script>
</body>
</html>