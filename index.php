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
    <style>
        /* === INTRO NETFLIX CSS === */
        
        /* Container de l'intro */
        .intro-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: #000;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            animation: introFadeOut 1s ease-in-out 4s forwards;
        }

        /* Bouton son */
        .sound-button {
            position: absolute;
            top: 30px;
            right: 30px;
            background: rgba(229, 9, 20, 0.8);
            border: 2px solid #e50914;
            color: white;
            padding: 15px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 1.5rem;
            transition: all 0.3s ease;
            z-index: 10;
            backdrop-filter: blur(10px);
        }

        .sound-button:hover {
            background: #e50914;
            transform: scale(1.1);
            box-shadow: 0 0 20px rgba(229, 9, 20, 0.5);
        }

        .sound-button.muted {
            background: rgba(100, 100, 100, 0.8);
            border-color: #666;
        }

        /* Instructions */
        .intro-instructions {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            text-align: center;
            opacity: 0.7;
            font-size: 0.9rem;
            animation: fadeInUp 1s ease-out 2s forwards;
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateX(-50%) translateY(20px);
            }
            100% {
                opacity: 0.7;
                transform: translateX(-50%) translateY(0);
            }
        }

        /* Logo Netflix */
        .logo-container {
            position: relative;
            z-index: 2;
        }

        .netflix-logo {
            font-size: 8rem;
            font-weight: 900;
            letter-spacing: 0.2em;
            color: #e50914;
            text-shadow: 0 0 20px #e50914;
            animation: logoZoom 3s ease-in-out;
        }

        .netflix-logo .letter {
            display: inline-block;
            animation: letterPop 0.5s ease-out;
            animation-fill-mode: both;
        }

        /* Animation décalée pour chaque lettre */
        .netflix-logo .letter:nth-child(1) { animation-delay: 0.1s; }
        .netflix-logo .letter:nth-child(2) { animation-delay: 0.2s; }
        .netflix-logo .letter:nth-child(3) { animation-delay: 0.3s; }

        /* Effet de lueur */
        .glow-effect {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(229, 9, 20, 0.3) 0%, transparent 70%);
            animation: glowPulse 2s ease-in-out infinite alternate;
            z-index: 1;
        }

        /* Animations */
        @keyframes letterPop {
            0% {
                transform: scale(0) rotateY(-180deg);
                opacity: 0;
            }
            50% {
                transform: scale(1.2) rotateY(-90deg);
            }
            100% {
                transform: scale(1) rotateY(0deg);
                opacity: 1;
            }
        }

        @keyframes logoZoom {
            0% {
                transform: scale(0.5);
                opacity: 0.8;
            }
            50% {
                transform: scale(1.1);
                opacity: 1;
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        @keyframes glowPulse {
            0% {
                transform: translate(-50%, -50%) scale(1);
                opacity: 0.5;
            }
            100% {
                transform: translate(-50%, -50%) scale(1.2);
                opacity: 0.8;
            }
        }

        @keyframes introFadeOut {
            0% {
                opacity: 1;
                transform: scale(1);
            }
            90% {
                opacity: 0.1;
                transform: scale(1.1);
            }
            100% {
                opacity: 0;
                transform: scale(1.2);
                visibility: hidden;
            }
        }

        /* Cache le contenu principal pendant l'intro */
        .main-site-content {
            opacity: 0;
            animation: mainContentFadeIn 1s ease-in-out 4.5s forwards;
        }

        @keyframes mainContentFadeIn {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive pour l'intro */
        @media (max-width: 768px) {
            .netflix-logo {
                font-size: 4rem;
            }
            .sound-button {
                top: 20px;
                right: 20px;
                padding: 10px;
                font-size: 1.2rem;
            }
        }
    </style>
</head>
<body>
    <!-- === INTRO NETFLIX === -->
    <div id="netflix-intro" class="intro-container">
        <div class="logo-container">
            <div class="netflix-logo">
                <span class="letter">N</span>
                <span class="letter">E</span>
                <span class="letter">T</span>
            </div>
        </div>
        <div class="glow-effect"></div>
        
        <div class="intro-instructions">
            <p>ESPACE ou ÉCHAP pour passer l'intro</p>
        </div>
    </div>

    <!-- Audio Netflix (ton fichier MP3) -->
    <audio id="netflix-audio" preload="auto">
        <source src="assets/netflix-intro.mp3" type="audio/mpeg">
        <source src="assets/netflix-intro.ogg" type="audio/ogg">
    </audio>

    <!-- === CONTENU PRINCIPAL DU SITE === -->
    <div class="main-site-content">
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
                    <a href="films.php" class="btn">📋 Voir tous les films</a>
                    <?php if (estConnecte()): ?>
                        <a href="admin.php" class="btn">➕ Ajouter un film</a>
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
    </div> <!-- Fin du contenu principal -->

    <!-- === JAVASCRIPT INTRO NETFLIX === -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const intro = document.getElementById('netflix-intro');
            const mainContent = document.querySelector('.main-site-content');
            const audio = document.getElementById('netflix-audio');
            
            // Démarre le son automatiquement après un court délai
            setTimeout(() => {
                audio.play().catch(function(error) {
                    // Continue l'animation même sans son
                });
            }, 800);
            
            // Fonction pour passer l'intro
            function skipIntro() {
                intro.style.animation = 'introFadeOut 0.8s ease-in-out forwards';
                mainContent.style.animation = 'mainContentFadeIn 0.8s ease-in-out 0.2s forwards';
                
                // Arrêter le son
                audio.pause();
                audio.currentTime = 0;
                
                setTimeout(() => {
                    intro.style.display = 'none';
                }, 800);
            }
            
            // Écoute des touches
            document.addEventListener('keydown', function(event) {
                if (event.code === 'Space' || event.code === 'Escape') {
                    event.preventDefault();
                    skipIntro();
                }
            });
            
            // Clic n'importe où pour passer
            intro.addEventListener('click', function() {
                skipIntro();
            });
            
            // Auto-skip après 5 secondes
            setTimeout(() => {
                if (intro.style.display !== 'none') {
                    skipIntro();
                }
            }, 5000);
        });
    </script>

    <!-- JavaScript pour le menu mobile -->
    <script src="js/mobile-menu.js"></script>
</body>
</html>