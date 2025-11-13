<?php
require_once 'config.php';

// Variables pour le formulaire
$message = '';
$message_type = '';
$login = '';

// Traitement du formulaire de connexion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $password = $_POST['password'] ?? '';
    
    // Validation des données
    if (empty($login)) {
        $message = 'Le login est obligatoire.';
        $message_type = 'error';
    } elseif (empty($password)) {
        $message = 'Le mot de passe est obligatoire.';
        $message_type = 'error';
    } else {
        // Tentative de connexion
        if (connecterUtilisateur($login, $password)) {
            $message = 'Connexion réussie ! Redirection vers l\'espace admin...';
            $message_type = 'success';
            
            // Redirection vers la page "Ajouter un film" (admin.php)
            header('refresh:1;url=admin.php');
        } else {
            $message = 'Login ou mot de passe incorrect';
            $message_type = 'error';
        }
    }
}

// Redirection si déjà connecté
if (estConnecte()) {
    header('Location: admin.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - NetflixX</title>
    
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Menu de navigation -->
    <div class="top-menu">
        <strong>NetflixX</strong>
        <a href="index.php">🏠 Accueil</a>
        <a href="films.php">🎬 Films</a>
        <a href="inscription.php">📝 Inscription</a>
        <a href="connexion.php" class="active">🔑 Connexion</a>
    </div>

    <div class="container">
        <div class="connexion-card">
            <!-- En-tête -->
            <h1 class="page-title">🔑 Connexion</h1>
            <p class="page-subtitle">
                Connectez-vous à votre compte NetflixX<br>
                pour accéder à l'espace admin.
            </p>

            <!-- Message de feedback -->
            <?php if (!empty($message)): ?>
                <div class="message <?php echo $message_type; ?>">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <?php if ($message_type !== 'success'): ?>
                <!-- Formulaire de connexion -->
                <form method="POST" action="connexion.php">
                    <div class="form-group">
                        <label for="login" class="form-label">
                            👤 Login
                        </label>
                        <input 
                            type="text" 
                            id="login" 
                            name="login" 
                            class="form-input"
                            value="<?php echo htmlspecialchars($login); ?>"
                            placeholder="Votre nom d'utilisateur"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">
                            🔒 Mot de passe
                        </label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            class="form-input"
                            placeholder="Votre mot de passe"
                            required
                        >
                    </div>

                    <button type="submit" class="submit-btn">
                        🚀 Se connecter
                    </button>
                </form>

                <!-- Lien vers l'inscription -->
                <div class="signup-link">
                    <p>Vous n'avez pas encore de compte ?</p>
                    <a href="inscription.php">📝 S'inscrire gratuitement</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>