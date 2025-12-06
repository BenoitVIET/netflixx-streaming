<?php
// Votre chef de projet vous propose de créer une plateforme de streaming en ligne qui
// propose une liste de films.
// Le site contient les pages suivantes :
// ➢ Page d’accueil : Affiche un message de bienvenue ainsi que les 5 derniers films
// ajoutés
// ➢ Page Liste de films : Affiche la liste complète de tous les films
// ➢ Page Film : Affiche les détails d’un film
// ➢ Page Inscription: Contient un formulaire pour s’inscrire
// ➢ Page Connexion : Permet de se connecter au site et d’accéder à la page Admin
// ➢ Page Admin (visible uniquement si on est connecté) : Permet d’ajouter un film

// Exercice 1 – Création de la base de données
// 1 - Créez une base de données selon les indications suivantes :
// DATABASE : tp_netflixx_nom_prenom
// TABLE : film
// -----
// id : PRIMARY KEY (INT) (AUTO INCREMENT)
// title : VARCHAR (255)
// description : VARCHAR (255)
// urlphoto : VARCHAR (255)
// urlvideo : TEXT (500)
// TABLE : user
// -----
// id : PRIMARY KEY (INT) (AUTO INCREMENT)
// login : VARCHAR (255)
// password : VARCHAR (255)

// Exercice 2 – Page d’accueil
// Créer une page d’accueil contenant :
// Une introduction (ex: nom du site, image marketing, message de bienvenue)
// Une liste des 5 films ajoutés sur le site
// Les films doivent apparaître dans l’ordre antéchronologique (la plus
// récente en premier)
// Pour chaque film, on doit voir le titre et la photo
// Seules les 5 derniers films ajoutées doivent apparaître
// Le titre des films doit être affiché en MAJUSCULES

// Exercice 3 – Menu
// Créer une barre de navigation qui sera présente sur toutes les pages avec les liens
// suivants :
// Accueil (lien vers page d’Accueil - visible pour tous)
// Consulter tous les films (lien vers page Consulter tous les films - visible pour
// tous)
// Espace admin (lien vers page Admin - accessible seulement si on est connecté)
// Inscription (lien vers page Inscription- visible pour tous)
// Connexion (vers page Connexion - visible pour tous)
// Se déconnecter (visible seulement si on est connecté)
// Remarque: Pour éviter de dupliquer le code du menu sur chaque page PHP, il est
// conseillé d’utiliser include() ou require().

// Exercice 4 – Consulter tous les films
// Créer une page « Consulter tous les films » :
// Tous les films doivent apparaître sur cette page sous la forme d’une liste. Pour
// chaque film, on doit afficher son titre, son auteur, sa photo, lien “Consulter ce
// film”)
// Un lien dirige vers la page « Consulter ce film » doit être présent sur chaque film.
// Créer une page « Détails » qui affiche les détails d’un film:
// Cette page est accessible quand on clique sur le lien « Consulter ce film » d’un
// film de la liste depuis la page « Consulter tous les films » :
// Cette page affiche tous les détails du film choisi (titre, auteur, description,
// photo, vidéo pouvant être lu sur le site (la vidéo sera un extrait ou d’une bande
// d’annonce récupérée sur youtube). Remarque: la vidéo doit pouvoir être lu
// directement sur votre site sans de redirection vers youtube
// Astuce 1: Pour les liens “Consulter ce film” et les pages Détails d’un film, utilise des
// paramètres dans les URLs et $_GET :
// https://www.youtube.com/watch?v=8_0Z9uPkxP4&list=PL5BcU-_5Oa_qP_kmIKZcroQ
// Lwu9GMVbOu&index=18 )
// Astuce 2: Pour intégrer une vidéo youtube, utiliser le code Iframe fourni par Youtube.
// Rends toi sur la vidéo puis clique sur le bouton Partager
// Puis sur le bouton Intégrer
// Récupère tout le code et intègre-le.
// Tu pourras le mettre dans ta base de données
// dans le champ urlvideo. Puis après avoir
// récupéré les éléments de ta base de données pour
// un film, mettre ce texte dans une variable et
// l’afficher avec un echo;

// Exercice 5 – Page Inscription
// Créer une page « Inscription » :
// Créer une page de formulaire accessible depuis la barre de navigation
// permettant de s’inscrire au site et contenant les champs suivants :
// login
// password
// Les informations seront stockées en base de données.
// Une fois le formulaire envoyé, le visiteur est redirigé vers la page Connexion

// Exercice 6 – Page Connexion
// Créer une page « Connexion » :
// Créer une page de formulaire accessible depuis la barre de navigation
// permettant de se connecter au site et contenant les champs suivants :
// login
// password
// Lorsque le formulaire est envoyé, le code vérifie si le login existe en base de
// données et si le mot de passe associé à ce login est correct
// Si c’est bon, le visiteur est redirigé vers la page “Ajouter un film”
// Si ce n’est pas bon, un message d’erreur “Login ou mot de passe
// incorrect” apparaît sur la page “Se connecter”

// Exercice 7 – Admin
// Créer la page « Admin » qui permet d’ajouter un film en base de donnée :
// Vous créerez une page de formulaire accessible depuis la barre de navigation
// seulement si le visiteur est connecté permettant l’ajout d’une film en base de
// données
// Le formulaire contenant les champs suivants :
// titre : <input type=”text”>
// description : <textarea”>
// photo : <input type=”file”>
// urlVideo : <input type=”text”>

// Remarque : chaque film ajouté doit être visible immédiatement sur la page “d'Accueil”
// et la page “Consulter les films”.