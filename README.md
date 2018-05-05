# ECE-LinkedIn

Projet de programmation web du second semestre pour la première année du cycle ingénieur de l'ECE.

## Téléchargement
Les versions publiées sont disponibles ici:
https://github.com/louisfelix90/ECE-LinkedIn/releases

## Installation
### Pré-requis
L'installation d'une application Laravel diffère d'une application PHP simple.

Il est tout d'abord nécessaire d'avoir le gestionnaire de paquet Composer (https://getcomposer.org/) d'installé.

Un VirtualHost dédié et PHP 7.0 sont également requis.

Il est possible de se passer du VirtualHost dédié (et du serveur) en utilisant le serveur interne de PHP, lançable par:
```
php -S localhost:8000 server.php
```

La recherche dépend d'un compte Algolia (https://algolia.com) et a besoin d'un numéro d'application et d'une clé API Algolia.
La version communautaire est largement suffisante pour ce projet.

### Procédure

Une fois les fichiers extraits dans un dossier VirtualHost dédié, il faut exécuter dans le répertoire la commande:
```
composer install
```

Une fois l'installation des dépendances effectuées, il est nécessaire de configurer l'application.

Copiez le fichier ``.env.example`` en ``.env`` et modifiez les valeurs nécessaires.
Le champ ``APP_URL`` doit correspondre au chemin du serveur/VirtualHost.

Générez la donnée ``APP_KEY`` avec la commande:
```
php artisan key:generate
```

Lancez enfin:
```
php artisan migrate
```

La base de donnée a été initialisée et l'application est prête à être utilisée.

## Dépendances
 - Laravel (et ses dépendances diverses) (https://laravel.com/)
 - Laravel Mix (https://laravel.com/)
 - Laravel Scout (https://laravel.com/)
 - Laravel Collective Forms (https://laravelcollective.com/)
 - Laravel Proxy Package (https://github.com/fideloper/TrustedProxy)
 - Algolia PHP client (https://www.algolia.com/)
 - Doctrine Database Abstraction Layer (https://www.doctrine-project.org/projects/dbal.html)
 - FlySystem Cache Adapter (https://github.com/thephpleague/flysystem-cached-adapter)
 - FlySystem Rackspace Adapter (https://github.com/thephpleague/flysystem-rackspace)

 - jQuery (https://jquery.com/)
 - Foundation for Sites (https://foundation.zurb.com/)
 - Riot.js (http://riotjs.com/)
 - Axios (https://github.com/axios/axios)
 - Loadash (https://lodash.com/)
 - Moment.js (https://momentjs.com/)
 - Algolia InstantSearch.js (https://community.algolia.com/instantsearch.js/)

 - Police d'écriture Open Sans (https://www.npmjs.com/package/typeface-open-sans)

## Références
Les ressources ont été utilisé pour la conception de ce projet :
 - http://www.csforum2014.com/callforspeakers/ pour l'image de profil par défaut
 - https://www.videezy.com/urban/66-melbourne-city-lights-stock-video-montage pour la vidéo de fond
 - http://image.ibb.co/i7NbrQ/search_icon_15.png pour l'icône de recherche
 - Wikipédia pour certaines descriptions

De manière plus général, les sites suivants ont été des références :
 - Documentation Laravel (https://laravel.com/)
 - Documentation Laravel Collective (https://laravelcollective.com/)
 - Laracasts (https://laracasts.com/)
 - Documentation Algolia
 - OpenClassrooms (https://openclassrooms.com/)
 - Stack Overflow (https://stackoverflow.com/​)​