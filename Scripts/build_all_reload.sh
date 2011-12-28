#!/bin/bash
# Update the database and load fixtures (to modify in order to make a clean drop/create table
# and enabling UTF8
clear;
php app/console doctrine:schema:update --force
php app/console doctrine:fixtures:load