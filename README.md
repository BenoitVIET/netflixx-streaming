# 🎬 NetflixX - Plateforme de Streaming

Une plateforme de streaming inspirée de Netflix, développée en PHP/MySQL avec un design responsive moderne.

![NetflixX](https://img.shields.io/badge/Version-2.0-red) ![PHP](https://img.shields.io/badge/PHP-7.4+-blue) ![MySQL](https://img.shields.io/badge/MySQL-5.7+-green) ![Responsive](https://img.shields.io/badge/Responsive-Mobile-brightgreen)

## ✨ Fonctionnalités Principales

- 🎭 **Intro Netflix animée** avec son authentique et animation "NET"
- 🏠 **Page d'accueil** avec les 5 derniers films
- 🎬 **Catalogue complet** des films avec pagination
- 📽️ **Pages détaillées** avec bandes-annonces YouTube intégrées
- 🔐 **Système d'authentification** complet (inscription/connexion)
- ⚙️ **Interface admin** pour gestion des films
- 🖼️ **Upload d'images** avec validation et optimisation
- 📱 **Design 100% responsive** avec menuburger
- 🎨 **Interface moderne** aux couleurs Netflix authentiques
- 👤 **Gestion d'utilisateurs** avec nom d'admin personnalisé

## 🚀 Nouvelles Fonctionnalités v2.0

### Navigation Mobile Optimisée
- **Menu hamburger** responsive avec animation fluide
- **Navigation unifiée** sur toutes les pages
- **JavaScript externalisé** pour une meilleure performance

### Architecture Optimisée
- **Code unifié** - Suppression des doublons CSS/JS (-70% de code)
- **Système boutons cohérent** - Classes unifiées `.btn` + modificateurs
- **Classes CSS consolidées** - Architecture modulaire et maintenable
- **Configuration centralisée** - Fonctions PHP unifiées

## 🛠️ Technologies utilisées

- **Backend :** PHP 7.4+ avec architecture modulaire
- **Base de données :** MySQL 5.7+ avec requêtes préparées
- **Frontend :** HTML5, CSS3 (Flexbox/Grid), JavaScript ES6+
- **Design :** Variables CSS, animations fluides, responsive mobile-first
- **Sécurité :** Hachage bcrypt, sessions PHP sécurisées
- **Upload :** Gestion sécurisée des images avec validation MIME
- **Architecture :** Code optimisé, classes unifiées, JavaScript externe

## 🎯 Optimisations v2.0

### Performance
- **-70% de code dupliqué** - Refactoring complet de l'architecture
- **JavaScript externe** - `mobile-menu.js` pour toutes les pages
- **CSS unifié** - Système de classes cohérent avec héritage
- **Fonctions centralisées** - Configuration PHP optimisée

### Responsive Design
- **Menu hamburger** avec animations CSS
- **Navigation adaptative** - Desktop et mobile
- **Grid responsive** - Films affichés parfaitement sur tous écrans
- **Variables CSS** - Breakpoints et espacements standardisés

### UX/UI
- **Design cohérent** - Interface Netflix authentique
- **Animations fluides** - Transitions CSS optimisées
- **Navigation intuitive** - Menu utilisateur repositionné
- **Feedback utilisateur** - Messages d'état et confirmations

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
├── index.php              # Page d'accueil avec intro Netflix
├── films.php              # Catalogue des films responsive
├── film.php               # Détail d'un film avec vidéo
├── inscription.php        # Inscription utilisateur
├── connexion.php          # Connexion avec validation
├── deconnexion.php        # Déconnexion sécurisée
├── admin.php              # Interface d'administration
├── config.php             # Configuration centralisée
├── styles.css             # CSS unifié et optimisé
├── js/
│   └── mobile-menu.js     # JavaScript pour menu mobile
├── uploads/images/        # Images uploadées
├── assets/
│   └── netflix-intro.mp3  # Son d'intro (optionnel)
├── .gitignore            # Fichiers ignorés
└── README.md             # Documentation complète
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

- **BenoitVIET** - Développeur principal et architecte
- Optimisations v2.0 : Navigation responsive, code unifié, UX améliorée

## 📝 Changelog v2.0

### 🆕 Nouvelles fonctionnalités
- Menu mobile hamburger avec animations
- Navigation unifiée sur toutes les pages
- Affichage du nom admin dans la navbar
- JavaScript externe pour de meilleures performances

### 🔧 Optimisations
- **Code cleanup** : -70% de duplication supprimée
- **CSS unifié** : Système de classes cohérent
- **Architecture modulaire** : Fonctions centralisées
- **Responsive optimisé** : Mobile-first design

### 🎨 Améliorations UI/UX
- Boutons avec système unifié (.btn + modificateurs)
- Navigation repositionnée pour meilleure ergonomie
- Animations CSS fluides et modernes
- Design 100% cohérent avec charte Netflix

### 🐛 Corrections
- Problèmes de navigation sur mobile résolus
- Compatibilité cross-browser améliorée
- Performance générale optimisée

### 🔐 Sécurité v2.1 (Décembre 2025)
- **Validation MIME implémentée** dans la fonction uploadImage() - Protection renforcée contre fichiers malveillants
- **Emoji déconnexion** corrigé (🚺 → 🚪) pour meilleure cohérence UX
- **Affichage nom utilisateur dynamique** - Chaque utilisateur voit son propre login dans la navbar

---

⭐ **NetflixX v2.1 - L'expérience streaming ultime !**