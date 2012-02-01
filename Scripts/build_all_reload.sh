#!/bin/bash
# Modify the script so the database is not dropped every time
clear;
echo "-- Jobeet2, reinitialization script --"
echo "- Re-initializing schema..."
php app/console doctrine:schema:update --force --env=$1
echo "- Loading fixtures..."
php app/console doctrine:fixtures:load --env=$1
echo "- Deleting logos..."
rm ./web/uploads/jobs/job_*
echo "- Deleting cache..."
rm -rf ./app/cache/*
echo "- Deleting logs..."
rm -rf ./app/logs/*
echo "- Done !"