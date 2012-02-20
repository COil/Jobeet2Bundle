#!/bin/bash

# Interesting options:
# --repeat 5          : Repeat the tests 5 times
# --tap ou --testdox  : Affichage des resultats des tests, --tap donne un affichage "a la symfony1"

clear;
php app/console doctrine:database:drop --force --env=test
php app/console doctrine:database:create --env=test
php app/console doctrine:schema:update --force --env=test
php app/console doctrine:fixtures:load --env=test
phpunit --debug -c app src/COil/Jobeet2Bundle/