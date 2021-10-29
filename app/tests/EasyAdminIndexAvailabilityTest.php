<?php

namespace App\Tests;

use App\Controller\UserCrudController;
use App\Entity\Core\User;
use EasyCorp\Bundle\EasyAdminBundle\Registry\CrudControllerRegistry;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Routing\RouterInterface;

class EasyAdminIndexAvailabilityTest extends WebTestCase
{
    protected ?KernelBrowser $client = null;
    private $userRepository;

    /**
     * @dataProvider availableIndexProvider
     *
     * @param string $crudFqcn
     */
    public function testAvailability(string $crudFqcn)
    {
        $client = static::createClient();
        $userRepository = self::getContainer()->get('doctrine')->getRepository(User::class);

        /** @var RouterInterface $router */
        $router = self::getContainer()->get(RouterInterface::class);
        /** @var CrudControllerRegistry $crudControllerRegistry */
        $crudControllerRegistry = self::getContainer()->get(CrudControllerRegistry::class);

        $crudId = $crudControllerRegistry->findCrudIdByCrudFqcn($crudFqcn);
        $route = $router->generate(
            'easy_admin_dashboard', [
                'crudId' => $crudId,
                'crudAction' => 'index',
            ]
        );

        $testUser = $userRepository->findOneBy(['email' => 'admin@admin.com']);

        $client->loginUser($testUser);

        $client->request('GET', $route);

        $this->assertResponseIsSuccessful();
    }

    public function availableIndexProvider()
    {
        yield [UserCrudController::class];
    }
}