<?php
require_once 'config.php';

// Récupérer les 5 derniers films ajoutés
$derniers_films = obtenirDerniersFilms(5);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NetflixX - Plateforme de streaming</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Menu de navigation -->
    <div class="top-menu">
        <div class="logo">NetflixX</div>
        <a href="index.php">🏠 Accueil</a>
        <a href="films.php">🎬 Films</a>
        <?php if (estConnecte()): ?>
            <a href="admin.php">⚙️ Admin</a>
            <span style="margin-left: 20px;">👤 <?php echo nettoyer(obtenirUtilisateur()); ?></span>
            <a href="deconnexion.php">🚪 Déconnexion</a>
        <?php else: ?>
            <a href="inscription.php">📝 Inscription</a>
            <a href="connexion.php">🔑 Connexion</a>
        <?php endif; ?>
    </div>

    <!-- Contenu principal -->
    <div class="main-content">
        <div class="container">
            <!-- Header de bienvenue -->
            <header class="header">
                <h1>Bienvenue sur NetflixX</h1>
                <p style="font-size: 1.2rem; color: #ddd;">
                    Découvrez une collection exceptionnelle de films en haute qualité.
                </p>
            </header>

            <!-- Section des derniers films -->
            <main class="films-section">
                <h2>🆕 Les 5 Derniers Films Ajoutés</h2>
                
                <?php if (empty($derniers_films)): ?>
                    <div class="no-video">
                        ❌ Aucun film disponible pour le moment.<br>
                        <small>Revenez bientôt pour découvrir nos nouveautés !</small>
                    </div>
                <?php else: ?>
                    <div class="films-grid">
                        <?php foreach ($derniers_films as $index => $film): ?>
                            <article class="film-card">
                                <span style="position: absolute; top: 10px; left: 10px; background: var(--netflix-red); color: white; padding: 5px 10px; border-radius: 15px; font-weight: bold;">#<?php echo $index + 1; ?></span>
                                
                                <?php if (!empty($film['urlphoto'])): ?>
                                    <img src="<?php echo htmlspecialchars($film['urlphoto']); ?>" 
                                         alt="<?php echo htmlspecialchars($film['title']); ?>"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div style="display: none; justify-content: center; align-items: center; height: 300px; background: #333; color: #999; border-radius: 8px;">
                                        🎬<br><?php echo htmlspecialchars(substr($film['title'], 0, 15)); ?>...
                                    </div>
                                <?php else: ?>
                                    <div style="display: flex; justify-content: center; align-items: center; height: 300px; background: #333; color: #999; border-radius: 8px;">
                                        🎬<br><?php echo htmlspecialchars(substr($film['title'], 0, 15)); ?>...
                                    </div>
                                <?php endif; ?>
                                
                                <h3><?php echo htmlspecialchars($film['title']); ?></h3>
                                <p><?php echo htmlspecialchars(substr($film['description'], 0, 100)); ?>...</p>
                                <a href="film.php?id=<?php echo $film['id']; ?>" class="btn">Voir le film</a>
                            </article>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- Actions rapides -->
                <section class="actions-section">
                    <a href="films.php" class="action-btn">📋 Voir tous les films</a>
                    <?php if (estConnecte()): ?>
                        <a href="admin.php" class="action-btn">➕ Ajouter un film</a>
                    <?php endif; ?>
                </section>
            </main>

            <!-- Footer -->
            <footer class="footer-info">
                <p>
                    <strong>NetflixX</strong> - Votre plateforme de streaming préférée<br>
                    <small>Découvrez, regardez, partagez !</small>
                </p>
            </footer>
        </div>
    </div>
</body>
</html>