# Modèles

L’application web utilise un modèle pour dialoguer avec une base de données plate.

## 1. Utilisateurs (User)

Classe : `User`

Namespace : `App`

Les utilisateurs sont dans le modèle “User”. 

Ils sont utilisés pour l’authentification à l’application. 

Le modèle `User` se base sur le modèle de base des utilisateurs dans Laravel. 
Le champ booléen “admin” a été rajouté pour pouvoir reconnaître un utilisateur basique d’un administrateur. 

## 2. Log d’activité (Log)

Classe : `Log`

Namespace : `App`

Les logs d’activité sont dans le modèle “Log”.

Ils sont utilisés pour tracer l’activité réalisée par les utilisateurs authentifiés de l’application. 

Les attributs du modèle “Log” sont :

- message : `la description du log d’activité`

- create_at : `la date de création du log d’activité`

- user : `l’utilisateur qui a réalisé l’activité`
