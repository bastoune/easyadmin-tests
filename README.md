# easyadmin-tests
## pre-requisites
- docker and docker-compose

## Try the project on navigator
- docker-compose up -d
- add easyadmin.test.local to your host
- got to https://easyadmin.test.local
- login as admin@admin.com with any password
- your should see the user list page

## run the tests and see the error
- docc exec test_easyadmin /bin/sh
- ./vendor/bin/phpunit
