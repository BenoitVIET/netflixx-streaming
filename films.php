<?php
require_once 'config.php';

// Récupérer tous les films
$tous_les_films = getTousLesFilms();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tous les Films - NetflixX</title>
    
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Menu de navigation -->
    <div class="top-menu">
        <strong>NetflixX</strong>
        <a href="index.php">🏠 Accueil</a>
        <a href="films.php" class="active">🎬 Films</a>
        <?php if (estConnecte()): ?>
            <a href="admin.php">⚙️ Admin</a>
            <span style="margin-left: 20px;">👤 <?php echo nettoyer(obtenirUtilisateur()); ?></span>
            <a href="deconnexion.php">🚪 Déconnexion</a>
        <?php else: ?>
            <a href="inscription.php">📝 Inscription</a>
            <a href="connexion.php">🔑 Connexion</a>
        <?php endif; ?>
    </div>

    <div class="container">
        <!-- En-tête de la page -->
        <header class="page-header">
            <h1 class="page-title">🎬 Consulter tous les films</h1>
            <p style="color: #666; font-size: 1.1rem;">
                Découvrez notre collection complète de films disponibles en streaming
            </p>
        </header>

        <!-- Section des films -->
        <main class="films-section">
            <?php if (empty($tous_les_films)): ?>
                <div class="no-films">
                    ❌ Aucun film disponible pour le moment.<br>
                    Revenez bientôt pour découvrir notre catalogue !
                </div>
            <?php else: ?>
                <div class="films-count">
                    📊 <strong><?php echo count($tous_les_films); ?></strong> film(s) disponible(s) dans notre catalogue
                </div>

                <div class="films-grid">
                    <?php foreach ($tous_les_films as $film): ?>
                        <article class="film-card">
                            <?php if (!empty($film['urlphoto'])): ?>
                                <img src="<?php echo htmlspecialchars($film['urlphoto']); ?>" 
                                     alt="<?php echo htmlspecialchars($film['title']); ?>" 
                                     class="film-image"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="film-placeholder" style="display: none;">
                                    🎬<br><?php echo htmlspecialchars(substr($film['title'], 0, 15)); ?>...
                                </div>
                            <?php else: ?>
                                <div class="film-placeholder">
                                    🎬<br><?php echo htmlspecialchars(substr($film['title'], 0, 15)); ?>...
                                </div>
                            <?php endif; ?>
                            
                            <div class="film-info">
                                <h3 class="film-title">
                                    <?php echo titreMajuscules(nettoyer($film['title'])); ?>
                                </h3>
                                
                                <?php if (!empty($film['description'])): ?>
                                    <p class="film-description">
                                        <?php echo htmlspecialchars(substr($film['description'], 0, 120)); ?>
                                        <?php if (strlen($film['description']) > 120): ?>...<?php endif; ?>
                                    </p>
                                <?php endif; ?>
                                
                                <a href="film.php?id=<?php echo $film['id']; ?>" class="btn">
                                    🔍 Consulter ce film
                                </a>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>