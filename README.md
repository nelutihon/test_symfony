test
====

db: 
 - test_symfony_test
 - test_symfony_dev
 - test_symfony_prod

app/console doctrine:migrations:execute 20150403082947

app/console --env=prod cache:clear


