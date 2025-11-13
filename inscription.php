<?php
require_once 'config.php';

// Variables pour le formulaire
$message = '';
$message_type = '';
$login = '';

// Traitement du formulaire d'inscription
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    // Validation des données
    if (empty($login)) {
        $message = 'Le login est obligatoire.';
        $message_type = 'error';
    } elseif (empty($password)) {
        $message = 'Le mot de passe est obligatoire.';
        $message_type = 'error';
    } elseif (strlen($password) < 6) {
        $message = 'Le mot de passe doit contenir au moins 6 caractères.';
        $message_type = 'error';
    } elseif ($password !== $confirm_password) {
        $message = 'Les mots de passe ne correspondent pas.';
        $message_type = 'error';
    } elseif (loginExiste($login)) {
        $message = 'Ce login est déjà utilisé. Veuillez en choisir un autre.';
        $message_type = 'error';
    } else {
        // Créer l'utilisateur
        if (creerUtilisateur($login, $password)) {
            $message = 'Inscription réussie ! Redirection vers la page de connexion...';
            $message_type = 'success';
            
            // Redirection après 2 secondes
            header('refresh:2;url=connexion.php');
        } else {
            $message = 'Erreur lors de l\'inscription. Veuillez réessayer.';
            $message_type = 'error';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - NetflixX</title>
    
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Menu de navigation -->
    <div class="top-menu">
        <strong>NetflixX</strong>
        <a href="index.php">🏠 Accueil</a>
        <a href="films.php">🎬 Films</a>
        <?php if (estConnecte()): ?>
            <a href="admin.php">⚙️ Admin</a>
            <span style="margin-left: 20px;">👤 <?php echo nettoyer(obtenirUtilisateur()); ?></span>
            <a href="deconnexion.php">🚪 Déconnexion</a>
        <?php else: ?>
            <a href="inscription.php" class="active">📝 Inscription</a>
            <a href="connexion.php">🔑 Connexion</a>
        <?php endif; ?>
    </div>

    <div class="container">
        <div class="inscription-card">
            <!-- En-tête -->
            <h1 class="page-title">📝 Inscription</h1>
            <p class="page-subtitle">
                Rejoignez NetflixX pour profiter de notre catalogue de films !<br>
                Créez votre compte gratuitement.
            </p>

            <!-- Message de feedback -->
            <?php if (!empty($message)): ?>
                <div class="message <?php echo $message_type; ?>">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <?php if ($message_type !== 'success'): ?>
                <!-- Informations -->
                <div class="form-info">
                    <strong>ℹ️ Informations :</strong><br>
                    • Le login doit être unique<br>
                    • Le mot de passe doit contenir au moins 6 caractères<br>
                    • Tous les champs sont obligatoires
                </div>

                <!-- Formulaire d'inscription -->
                <form method="POST" action="inscription.php">
                    <div class="form-group">
                        <label for="login" class="form-label">
                            👤 Login <span class="required">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="login" 
                            name="login" 
                            class="form-input"
                            value="<?php echo htmlspecialchars($login); ?>"
                            placeholder="Choisissez votre nom d'utilisateur"
                            required
                            maxlength="255"
                        >
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">
                            🔒 Mot de passe <span class="required">*</span>
                        </label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            class="form-input"
                            placeholder="Au moins 6 caractères"
                            required
                            minlength="6"
                        >
                    </div>

                    <div class="form-group">
                        <label for="confirm_password" class="form-label">
                            🔒 Confirmer le mot de passe <span class="required">*</span>
                        </label>
                        <input 
                            type="password" 
                            id="confirm_password" 
                            name="confirm_password" 
                            class="form-input"
                            placeholder="Répétez votre mot de passe"
                            required
                            minlength="6"
                        >
                    </div>

                    <button type="submit" class="submit-btn">
                        🚀 Créer mon compte
                    </button>
                </form>

                <!-- Lien vers la connexion -->
                <div class="login-link">
                    <p>Vous avez déjà un compte ?</p>
                    <a href="connexion.php">🔑 Se connecter</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>