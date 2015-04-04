test
====

Database: 
 - test_symfony_test
 - test_symfony_dev
 - test_symfony_prod

curl -sS https://getcomposer.org/installer | php

php composer.phar install
 
app/console doctrine:migrations:execute 20150403082947

app/console doctrine:migrations:execute 20150403082947 --env=prod

app/console --env=dev cache:clear

app/console --env=prod cache:clear


