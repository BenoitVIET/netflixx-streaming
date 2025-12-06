<?php
require_once 'config.php';

// Récupérer l'ID du film depuis l'URL
$film_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($film_id <= 0) {
    // Redirection si l'ID n'est pas valide
    header('Location: films.php');
    exit;
}

// Récupérer les détails du film
$film = obtenirFilmParId($film_id);

if (!$film) {
    // Redirection si le film n'existe pas
    header('Location: films.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($film['title']); ?> - NetflixX</title>
    
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Menu de navigation -->
    <div class="top-menu">
        <div class="logo">NetflixX</div>
        <div class="burger-menu" onclick="toggleMenu()">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <div class="nav-links" id="navLinks">
            <a href="index.php">🏠 Accueil</a>
            <a href="films.php">🎬 Films</a>
        <?php if (estConnecte()): ?>
            <a href="admin.php">⚙️ Admin</a>
            <a href="deconnexion.php">🚪 Déconnexion</a>
            <span style="margin-left: 20px;">👤 <?php echo nettoyer(obtenirUtilisateur()); ?></span>
        <?php else: ?>
            <a href="inscription.php">📝 Inscription</a>
            <a href="connexion.php">🔑 Connexion</a>
        <?php endif; ?>
        </div>
    </div>

    <div class="container">
        <!-- Lien retour -->
        <a href="films.php" class="back-link">
            ← Retour à la liste des films
        </a>

        <!-- Détails du film -->
        <main class="film-details">
            <!-- En-tête du film -->
            <header class="film-header">
                <h1 class="film-title">
                    <?php echo titreMajuscules(nettoyer($film['title'])); ?>
                </h1>
                <span class="film-id-badge">Film #<?php echo $film['id']; ?></span>
            </header>

            <!-- Contenu principal -->
            <div class="film-content">
                <!-- Image du film -->
                <div class="film-image-section">
                    <?php if (!empty($film['urlphoto'])): ?>
                        <img src="<?php echo htmlspecialchars($film['urlphoto']); ?>" 
                             alt="<?php echo htmlspecialchars($film['title']); ?>" 
                             class="film-image"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="film-placeholder" style="display: none;">
                            🎬<br><?php echo htmlspecialchars($film['title']); ?>
                        </div>
                    <?php else: ?>
                        <div class="film-placeholder">
                            🎬<br><?php echo htmlspecialchars($film['title']); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Informations du film -->
                <div class="film-info-section">
                    <h3>📋 Description</h3>
                    <?php if (!empty($film['description'])): ?>
                        <div class="film-description">
                            <?php echo nl2br(htmlspecialchars($film['description'])); ?>
                        </div>
                    <?php else: ?>
                        <div class="film-description">
                            Aucune description disponible pour ce film.
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Section vidéo -->
            <section class="video-section">
                <h3>🎥 Bande-annonce / Extrait</h3>
                
                <?php 
                // Logique intelligente pour les vidéos :
                // 1. D'abord vérifier s'il y a une vidéo en base de données
                // 2. Sinon utiliser la fonction obtenirBonneVideo() comme fallback
                $video_a_afficher = null;
                
                // Priorité 1 : Vidéo stockée en base (ajoutée via admin)
                if (!empty($film['urlvideo']) && trim($film['urlvideo']) !== '') {
                    $video_a_afficher = $film['urlvideo'];
                    $source_video = "base de données";
                } else {
                    // Priorité 2 : Vidéo de la fonction (films par défaut)
                    $video_fonction = obtenirBonneVideo($film['id'], $film['title']);
                    if ($video_fonction) {
                        $video_a_afficher = $video_fonction;
                        $source_video = "fonction obtenirBonneVideo";
                    }
                }
                ?>
                
                <?php if ($video_a_afficher): ?>
                    <div class="video-container">
                        <?php echo $video_a_afficher; ?>
                    </div>
                <?php else: ?>
                    <div class="no-video">
                        📹 Aucune vidéo disponible pour ce film.<br>
                        <small>La vidéo sera ajoutée prochainement.</small>
                    </div>
                <?php endif; ?>
            </section>

            <!-- Actions -->
            <section class="actions-section">
                <a href="films.php" class="btn">
                    📋 Voir tous les films
                </a>
                <a href="index.php" class="btn">
                    🏠 Retour à l'accueil
                </a>
            </section>
        </main>
    </div>

    <!-- JavaScript pour le menu mobile -->
    <script src="js/mobile-menu.js"></script>
</body>
</html>