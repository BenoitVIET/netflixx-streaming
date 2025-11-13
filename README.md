# 🎬 NetflixX - Plateforme de Streaming

Une plateforme de streaming inspirée de Netflix, développée en PHP/MySQL avec un design responsive moderne.

![NetflixX](https://img.shields.io/badge/Version-2.0-red) ![PHP](https://img.shields.io/badge/PHP-7.4+-blue) ![MySQL](https://img.shields.io/badge/MySQL-5.7+-green)

## ✨ Fonctionnalités

- � **Intro Netflix animée** avec son authentique et animation "NET"
- �🏠 **Page d'accueil** avec les 5 derniers films
- 🎬 **Catalogue complet** des films
- 📽️ **Pages détaillées** avec bandes-annonces YouTube
- 🔐 **Système d'authentification** (inscription/connexion)
- ⚙️ **Interface admin** pour ajouter des films
- 🖼️ **Upload d'images** avec validation
- 📱 **Design responsive** optimisé mobile
- 🎨 **Interface moderne** aux couleurs NetflixX

## 🛠️ Technologies utilisées

- **Backend :** PHP 7.4+
- **Base de données :** MySQL 5.7+
- **Frontend :** HTML5, CSS3 (Flexbox/Grid)
- **Sécurité :** Hachage bcrypt, sessions PHP
- **Upload :** Gestion sécurisée des images

## 🎥 Intro Netflix

La plateforme démarre avec une **intro animée authentique** :

- **Animation "NET"** - Lettres qui apparaissent progressivement avec effets visuels
- **Son Netflix** - Audio original synchronisé avec l'animation
- **Contrôles** - ESPACE, ÉCHAP ou clic pour passer l'intro
- **Auto-skip** - Transition automatique après 5 secondes
- **Design épuré** - Interface minimaliste pour une immersion totale

Pour ajouter votre propre son Netflix, placez le fichier `netflix-intro.mp3` dans le dossier `assets/`.

## 📋 Prérequis

- Serveur web (Apache/Nginx)
- PHP 7.4 ou supérieur
- MySQL 5.7 ou supérieur
- Extension PDO MySQL activée

## 🚀 Installation

### 1. Cloner le projet
```bash
git clone https://github.com/votre-username/netflixx.git
cd netflixx
```

### 2. Configuration de la base de données

**⚠️ IMPORTANT** : Ce projet utilise un template sécurisé pour la base de données.

```sql
-- 1. Créer votre base (changez le nom)
CREATE DATABASE netflixx_streaming CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- 2. Importer la structure depuis le template
mysql -u root -p netflixx_streaming < database_template.sql

-- 3. Créer votre utilisateur admin (en PHP)
```

**Créer l'admin en PHP** :
```php
<?php
// Script à exécuter UNE FOIS pour créer l'admin
require_once 'config.php';

$login = 'votre_admin';  // Changez ceci
$password = password_hash('mot_de_passe_secure', PASSWORD_DEFAULT);

$pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
$stmt = $pdo->prepare("INSERT INTO user (login, password) VALUES (?, ?)");
$stmt->execute([$login, $password]);

echo "Admin créé avec succès !";
?>
```

### 3. Configuration PHP
```bash
# Copier le template de configuration
cp config.template.php config.php

# Éditer config.php avec vos paramètres
nano config.php
```

Modifiez dans `config.php` :
```php
$host = 'localhost';
$dbname = 'tp_netflixx_votre_nom';  // Votre nom de BDD
$username = 'votre_user';           // Votre utilisateur MySQL  
$password = 'votre_password';       // Votre mot de passe MySQL
```

### 4. Permissions et images d'exemple
```bash
# Créer le dossier uploads
mkdir uploads/images/

# Copier les images d'exemple
cp sample-images/* uploads/images/

# Permissions (Unix/Linux)
chmod 755 uploads/
chmod 755 uploads/images/
```

### 5. Premiers tests
- Visitez `http://localhost/votre-projet/`
- Les films d'exemple s'afficheront avec leurs images
- Connectez-vous en admin pour tester l'ajout de films

## 📂 Structure du projet

```
netflixx/
├── index.php              # Page d'accueil
├── films.php              # Catalogue des films
├── film.php               # Détail d'un film
├── inscription.php        # Inscription utilisateur
├── connexion.php          # Connexion utilisateur
├── deconnexion.php        # Déconnexion
├── admin.php              # Interface d'administration
├── config.php             # Configuration (à créer)
├── config.template.php    # Template de configuration
├── styles.css             # Styles CSS unifiés
├── create_database.sql    # Structure de la base de données
├── uploads/images/        # Images uploadées
├── .gitignore            # Fichiers ignorés par Git
└── README.md             # Documentation
```

## 🔧 Utilisation

### Première connexion

1. **Créer un compte** via l'inscription
2. **Se connecter** avec vos identifiants
3. **Accéder à l'admin** pour ajouter des films

### Ajouter des films

1. Se connecter en tant qu'admin
2. Aller sur l'interface admin
3. Remplir le formulaire (titre, description, image, vidéo YouTube)
4. Valider l'ajout

### Formats supportés

- **Images :** JPG, PNG, GIF, WebP (max 5MB)
- **Vidéos :** Iframes YouTube intégrées

## 🎨 Captures d'écran

### Page d'accueil
Interface moderne avec les derniers films ajoutés.

### Catalogue
Grille responsive de tous les films disponibles.

### Page film
Détails complets avec bande-annonce YouTube intégrée.

## 🔒 Sécurité

- ✅ **Mots de passe hachés** avec bcrypt
- ✅ **Sessions PHP** sécurisées
- ✅ **Validation des uploads** d'images
- ✅ **Protection XSS** avec htmlspecialchars()
- ✅ **Requêtes préparées** contre les injections SQL

## 🐛 Dépannage

### Problème de connexion
- Vérifiez les paramètres dans `config.php`
- Assurez-vous que la base de données existe
- Contrôlez les permissions MySQL

### Upload d'images impossible
- Vérifiez les permissions du dossier `uploads/`
- Contrôlez la taille max d'upload PHP (`upload_max_filesize`)

### Erreur 500
- Activez l'affichage des erreurs PHP
- Consultez les logs d'erreur du serveur web

## 📝 Licence

Ce projet est sous licence MIT. Voir le fichier `LICENSE` pour plus de détails.

## 👥 Contributeurs

- **Benoit VIET** - Développeur principal

## 🤝 Contribution

Les contributions sont les bienvenues ! N'hésitez pas à :

1. Fork le projet
2. Créer une branche feature (`git checkout -b feature/nouvelle-fonctionnalite`)
3. Commit vos changements (`git commit -am 'Ajout nouvelle fonctionnalité'`)
4. Push sur la branche (`git push origin feature/nouvelle-fonctionnalite`)
5. Ouvrir une Pull Request

---

⭐ **N'hésitez pas à mettre une étoile si ce projet vous a été utile !**