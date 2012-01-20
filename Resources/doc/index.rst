Jobeet2
=======

Current Symfony2 version: 2.0.9

This is full Jobeet2 tutorial for Symfony2. All the code was done by me and I didn't
cheat on others implementations so the code may vary with what you'll find on other
Jobeet2 repositories.

Nevertheless, I tried to produce the cleanest code I could by respecting 100%
of the Symfony2 coding standarts.


DAY1
----

1) Installation
---------------

Download the Symfony2 standart edition.
Follow the instructions mentionned in the README.md file and remove the demo Acme
bundle.

### Testing configuration

$ php app/check.php

Correct your configuration depending on the results.
(Note that your PHP cli configuration could be different from your Apache one)

2) Bundle initialization
------------------------

$ php app/console generate:bundle

* Namespace: "COil/Jobeet2Bundle"
* Bundle name: "Jobeet2Bundle"
* Target directory: leave the default value
* Format to use: leave the default value
* Generate the whole directory structure: "yes"
* Confirm: "yes"


DAY3
----

* Créer la table category avec tous les champs
* Executer les 2 commandes suivantes

php app/console doctrine:mapping:convert yml ./src/COil/Jobeet2Bundle/Resources/config/doctrine/metadata/orm --from-database --force
php app/console doctrine:mapping:import Jobeet2Bundle annotation
php app/console doctrine:generate:entities Jobeet2Bundle


* Installation du plugin de chargement de fixtures

http://symfony.com/doc/current/bundles/DoctrineFixturesBundle/index.html



Differences entre symfony1 et Symfony2
--------------------------------------

- Pas de slot dans Symfony, il suffit d'utiliser la notion de Block de Twig (Day 4)
- Pas de Doctrine Route dans Symfony2 (Day 5)


Problemes en cours
------------------


TODO
----

- Utiliser le DoctrineExtensions bundle pour gerer les slugs et timestampable


TUNING / OPTIMISATIONS
----------------------

- Methode findAllActiveJobs, virer la possibilite de passer un query builder ?


FINALISATION DU BUNDLE
----------------------

- Fichiers a inclure dans le Bundle:
    /app/config/parameters.ini
    /app/config/routing.yml


== Temp