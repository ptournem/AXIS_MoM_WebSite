# Installation de l'application


## Prérequis

* Gestionnaire de dépendance php pour Laravel : [composer](https://getcomposer.org/download/)

Pour la doc :

* Python 2.7.x + pip 1.5.x et Mkdocs : [MkDocs](http://www.mkdocs.org/)

Pour le dev :

* Serveur Apache avec PHP 5.5.9 minimum

* MySQL

## 1. Clonage du repository 

Se rendre à l'adresse du repository et télécharger un copy de la branche `master` du repository

Si Git est installé sur votre machine lancez la commande : 
	
	git clone adresse_du_repo repartoire_cible

## 2. Installation des dépendances php

Dans le dossier de laravel où vous avez cloné le repository, ouvrez une console et entrer:

    composer.phar install

Cela peut prendre plusieurs minutes. 

	
## 3. Renseignement du fichier .env

Ouvrez le fichier .env situé à la racine du repository 
	
	APP_DEBUG=false
	DB_HOST= adresse du serveur MySQL
	DB_DATABASE= nom de la base de données
	DB_USERNAME= utilisateur de la base de données
	DB_PASSWORD= mot de passe de l'utilisateur
	AXIS_MoM_WSDL= url du WSDL du web service 

## 4. Installation de la base de données

Dans la console à la raine du repository.
Créer les tables avec la commande :  

	php artisan migrate
	
Créer les données de base avec la commande : 

	php artisan db:seed
	
## 5. Répertoires et droits 

Créer le répertoire "*uploads*" à la racine du repository, c'est lui qui recevra les images uploadées pour les entités.

(!) Tous les fichiers du repository doivent être accessibles et lisibles par Apache. De même, Apache doit avoir les droits d'écriture dans les dossiers **bootstrap** et **storage**. 

