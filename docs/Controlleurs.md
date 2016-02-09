# Contrôleurs

Plusieurs contrôleurs sont disponibles dans l’application
		
##Commentaire

Namespace : `App\Http\Controllers`

Le contrôleur des commentaires `CommentController` permet :

* l’ajout d’un commentaire
* la validation d’un commentaire
* le refus d’un commentaire 
* la suppression d’un commentaire.

##Administrateur

Namespace : `App\Http\Controllers\Admin`

Le contrôleur d’administration `AdminController` permet :

* l’affichage de la zone d’administration
* l’affichage de l’administration d’une entité
* l’ajout d’entité
* la modification d’une propriété d’une entité
* la suppression de la valeur d’une propriété d’une entité
		
##Public

Namespace : `App\Http\Controller`

Le contrôleur d’affichage public `PublicController` permet :

* l’affichage de l’index
* l’affichage d’une entité
* la recherche d’une entité depuis un texte

##Logs

Namespace : `App\Http\Controllers\Admin`

Le contrôleur des logs d’activité “LogController” permet :

* La suppresion de tous les logs d’activité

##Authentification

Namespace : `App\Http\Controllers\Auth`

Le controlleur d’authentification `AuthentificationController` permet : 

* la connexion d’un utilisateur
* la déconnexion d’un utilisateur

#Middleware

Plusieurs middleware ont été ajoutés à l’application.

##auth

Classe : `Authenticate`

Namespace : `App\Http\Middleware`

Ce middleware a été ajouté pour vérifié qu’une utilisateur est bien authentifié. 

##isAdmin

Classe : `IsAdmin`

Namespace : `App\Http\Middleware`

Ce middleware a été ajouté pour vérifié qu’un utilisateur est bien authentifié et a les droits d’administration. 

#Tests unitaires

Les tests unitaires sont réalisés sur les controllers : 

* PublicController
* CommentController
* Admin\LogsController
* Admin\AdminController
