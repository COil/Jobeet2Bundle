#!/bin/bash
clear;
echo "> Update the Symfony2 version by getting the last vendors file and additional deps"
date

# Testing arguments
EXPECTED_ARGS=1
E_BADARGS=65
if [ $# -ne $EXPECTED_ARGS ]
then
  echo "Usage: `basename $0` 2.x.x"
  exit $E_BADARGS
fi

echo "> Getting new deps files..."
curl -O https://raw.github.com/symfony/symfony-standard/v$1/deps > deps
curl -O https://raw.github.com/symfony/symfony-standard/v$1/deps.lock > deps.lock
echo "> Done!"

echo "> Addind personal deps..."
cat src/COil/Jobeet2Bundle/Install/deps.add >> deps
cat src/COil/Jobeet2Bundle/Install/deps.lock.add >> deps.lock
echo "> Done!"

echo "> Updating vendors..."
rm -rf vendor/*
php bin/vendors install --reinstall
echo "> Done!"
date