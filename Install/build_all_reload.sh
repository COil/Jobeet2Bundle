#!/bin/bash
echo "-- Jobeet2, reinitialization script --"
# TODO: Modify the script so the database is dropped but the collation is correct

# Testing number of arguments
EXPECTED_ARGS=1
E_BADARGS=65
if [ $# -ne $EXPECTED_ARGS ]
then
  echo "/!\ Error: Please enter as 1st argument of the script the Symfony2 environment to use /!\ "
  echo " - Example: ./`basename $0` dev"
  exit $E_BADARGS
fi

# Reset
clear;
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