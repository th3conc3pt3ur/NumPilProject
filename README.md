NumPilProject
=============

Exercice Symfony utilisé pour le recrutement d'ACSEO.

## Contexe
Vous venez d'être embauché à l'Aéroport de Marseille Provence ! Félicitations. Au sein du nouveau département Web & Nouvelles Technologies, vous êtes chargés de mettre en place un prototype d'Application de gestion et planification des vols afin de montrer le potentiel que représente une application moderne en remplacement de l'outil vieillissant utilisé jusqu'à présent.

Votre Chef de projet vous demande de réaliser une application Web basée sur **Symfony**. Cette application devra respecter le cahier des charges ci-dessous.

**Afin de pouvoir juger la qualité de votre travail, votre Chef de projet vous demande de développer cette application en détaillant au maximum vos choix à travers les commentaires dans votre code ou les commits effectués au fur-et-à-mesure.**

## Cahier des charges

### Environnement technique :
**Obligatoire**

* Symfony 2
* Git

**Recommandé** *Vous pouvez vous en passer si vos choix sont justifiés*

* ORM Doctrine
* jQuery et Twitter Bootstrap
* FOSUserBundle

### Spécifications fonctionnelles :

L'application doit pouvoir représenter des passagers, des vols, des pilotes et des avions afin de modéliser l'activité de l'aéroport.
L'objectif de ce prototype n'est pas d'aller dans le détail de chaque domaine Métier, mais de montrer ce qu'il est envisageable de faire.
Ainsi, nous pourrions imaginer :
* Qu'un passager peut se connecter et consulter la liste de ses vols.
* Qu'un pilote peut se connecter et consulter la liste de ses vols.
* Qu'un gestionnaire de l'aéroport pourra affecter un avion et un pilote à un vol.
* Qu'un responsable pourra consutler l'activité de son aéroport.

Des règles de gestion élémentaires seront implémentées :
* Un passager ou un pilote ne peuvent pas être dans deux vols simultanéments.
* Le nombre de passagers d'un avion ne peut pas excéder la capacité de l'avion.
* Un vol doit avoir une ville de départ et une ville d'arrivée.
* *toute autre règle métier qui semble pertinente*

Gardez en tête que l'application développée doit être simple d'utilisation, moderne afin de satisfaire le personnel de l'aéroport, lassé de sa *vieille* application. Des principes d'ergnonimie généraux devront être respectés afin de donner une cohérence à l'application :
* Filtre sur les listing
* Pagination des éléments
* *Tout élement qui vous semble pertinent*

Pour finir, une documentation technique devra être livrée afin que la DSI puisse mettre sur un serveur de préproduction votre projet, à moins que vous le le déployiez vous même.

**Bon courage !**

