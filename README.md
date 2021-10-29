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
```
1) App\Tests\EasyAdminIndexAvailabilityTest::testAvailability with data set #0 ('App\Controller\UserCrudController', 'User')
TypeError: Argument 1 passed to EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator::setController() must be of the type string, null given, called in /var/www/test_easyadmin/vendor/twig/twig/src/Extension/CoreExtension.php on line 1544
```
