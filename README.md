# Forum / Page de discussion 

## Description du projet

Ce projet fait partie de **Startup Academy**, une initiative visant à créer un ensemble d'outils pour les startups. Cette application spécifique est une page de discussion de type Discord, permettant aux utilisateurs de créer et gérer des canaux de discussion, envoyer des messages, et interagir de manière anonyme. Les utilisateurs peuvent également utiliser des emojis dans leurs messages et les liens envoyés sont vérifiés pour leur sécurité.

Les principales fonctionnalités incluent un système CRUD pour les messages et les canaux, un mode anonyme, ainsi qu’une intégration avec des APIs externes pour la modération (Sightengine) et la vérification des liens (VirusTotal).

## Fonctionnalités principales

- **CRUD pour les messages et les canaux**  
  Les utilisateurs peuvent créer, lire, mettre à jour et supprimer des messages ainsi que des canaux.
  
- **Mode anonyme**  
  En mode anonyme, le nom de l'expéditeur n'est pas visible dans le canal.

- **Support d'emojis**  
  Les messages peuvent contenir des emojis pour une meilleure expérience utilisateur.

- **API de modération Sightengine**  
  Utilisation de l'API Sightengine pour la modération des contenus envoyés sur la plateforme.

- **Vérification des liens avec l'API VirusTotal**  
  Vérification des liens envoyés dans les messages en utilisant l'API VirusTotal pour garantir la sécurité des utilisateurs.

## Technologies utilisées

- **Frontend :** HTML, JavaScript, CSS
- **Backend :** PHP
- **Base de données :** MySQL (via XAMPP)
- **Serveur :** Apache (via XAMPP)
- **APIs externes :**
  - **Sightengine (pour la modération)**
  - **VirusTotal (pour la vérification des liens)**

## Installation

1. Clonez ou téléchargez ce projet.
2. Installez [XAMPP](https://www.apachefriends.org/index.html) et démarrez Apache et MySQL.
3. Placez les fichiers du projet dans le répertoire `htdocs` de XAMPP.
4. Importez la base de données SQL incluse (ou créez une base de données et ajustez les paramètres de connexion PHP).
5. Accédez à `localhost` dans votre navigateur pour commencer à utiliser le forum.

## API utilisées

### Sightengine API
Utilisée pour la modération des contenus envoyés par les utilisateurs. Cette API détecte les images, les textes inappropriés et autres contenus problématiques.

- **Documentation :** [Sightengine API](https://sightengine.com)

### VirusTotal API
Vérifie les liens envoyés dans les messages pour s'assurer qu'ils ne sont pas malveillants.

- **Documentation :** [VirusTotal API](https://www.virustotal.com)

## Contribution

Les contributions sont les bienvenues ! Si vous souhaitez contribuer, vous pouvez ouvrir une issue ou soumettre une pull request avec des améliorations ou des corrections de bugs.

## Auteurs

- Aouadi Moahmmed Yassine - Développeur principal.
