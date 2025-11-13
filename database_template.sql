-- NetflixX - Structure de base de données
-- Plateforme de streaming - Version publique

-- 1. Création de la base de données
CREATE DATABASE IF NOT EXISTS netflixx_streaming 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

-- Utiliser la base de données
USE netflixx_streaming;

-- 2. Création de la table film
CREATE TABLE film (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL COMMENT 'Titre du film',
    description VARCHAR(255) COMMENT 'Description/synopsis',
    urlphoto VARCHAR(255) COMMENT 'Chemin vers image du film',
    urlvideo TEXT COMMENT 'Iframe YouTube ou chemin vidéo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3. Création de la table user
CREATE TABLE user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(255) NOT NULL UNIQUE COMMENT 'Login utilisateur',
    password VARCHAR(255) NOT NULL COMMENT 'Mot de passe haché (bcrypt)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 4. Insertion de films de démonstration
INSERT INTO film (title, description, urlphoto, urlvideo) VALUES 
('Avatar', 'Un marine paraplégique est envoyé sur la planète Pandora pour une mission unique.', 'uploads/images/avatar.jpg', '<iframe width="560" height="315" src="https://www.youtube.com/embed/5PSNL1qE6VY" title="Avatar Trailer" frameborder="0" allowfullscreen></iframe>'),

('Titanic', 'L''histoire d''amour tragique entre Jack et Rose à bord du navire le plus célèbre du monde.', 'uploads/images/titanic.jpg', '<iframe width="560" height="315" src="https://www.youtube.com/embed/I7c1etV7D7g" title="Titanic Trailer" frameborder="0" allowfullscreen></iframe>'),

('Inception', 'Un voleur expert dans l''art d''extraire les secrets du subconscient humain.', 'uploads/images/inception.jpg', '<iframe width="560" height="315" src="https://www.youtube.com/embed/YoHD9XEInc0" title="Inception Trailer" frameborder="0" allowfullscreen></iframe>'),

('Interstellar', 'Une équipe d''explorateurs utilise une faille dans l''espace-temps pour tenter de sauver l''humanité.', 'uploads/images/interstellar.jpg', '<iframe width="560" height="315" src="https://www.youtube.com/embed/zSWdZVtXT7E" title="Interstellar Trailer" frameborder="0" allowfullscreen></iframe>'),

('The Matrix', 'Un programmeur découvre que la réalité qu''il connaît n''est qu''une simulation informatique.', 'uploads/images/matrix.jpg', '<iframe width="560" height="315" src="https://www.youtube.com/embed/vKQi3bBA1y8" title="Matrix Trailer" frameborder="0" allowfullscreen></iframe>'),

('Gladiator', 'Un général romain devient gladiateur pour venger la mort de sa famille et de son empereur.', 'uploads/images/gladiator.jpg', '<iframe width="560" height="315" src="https://www.youtube.com/embed/owK1qxDselE" title="Gladiator Trailer" frameborder="0" allowfullscreen></iframe>'),

('The Dark Knight', 'Batman affronte le Joker dans une bataille psychologique épique pour l''âme de Gotham City.', 'uploads/images/dark_knight.jpg', '<iframe width="560" height="315" src="https://www.youtube.com/embed/EXeTwQWrcwY" title="Dark Knight Trailer" frameborder="0" allowfullscreen></iframe>'),

('Pulp Fiction', 'Les destins croisés de plusieurs personnages dans le Los Angeles criminel des années 90.', 'uploads/images/pulp_fiction.jpg', '<iframe width="560" height="315" src="https://www.youtube.com/embed/s7EdQ4FqbhY" title="Pulp Fiction Trailer" frameborder="0" allowfullscreen></iframe>');

-- 5. IMPORTANT: Créer votre utilisateur admin
-- Remplacez 'your_admin_login' et utilisez un mot de passe sécurisé
-- Le mot de passe doit être haché avec password_hash() en PHP

-- Exemple de création d'utilisateur (à adapter):
-- INSERT INTO user (login, password) VALUES 
-- ('your_admin_login', 'HASH_PASSWORD_HERE');

-- Pour générer un hash de mot de passe sécurisé, utilisez en PHP:
-- $hash = password_hash('votre_mot_de_passe', PASSWORD_DEFAULT);

-- 6. Vérifications (optionnel)
-- Décommentez pour voir les données insérées

-- SELECT 'Films créés:' as Info;
-- SELECT id, title, LEFT(description, 50) as description_apercu FROM film;

-- SELECT 'Structure des tables:' as Info;
-- DESCRIBE film;
-- DESCRIBE user;

-- 7. Index pour les performances (recommandé en production)
CREATE INDEX idx_film_title ON film(title);
CREATE INDEX idx_user_login ON user(login);

-- 8. Notes d'installation:
-- 1. Changez le nom de la base de données selon vos besoins
-- 2. Créez votre utilisateur admin avec un mot de passe sécurisé
-- 3. Ajustez les permissions MySQL selon votre environnement
-- 4. Configurez config.php avec vos paramètres de connexion