<?php
/**
 * @author Bastien SANDER <bastien@heyliot.com>
 * @copyright 2020 Heyliot (http://www.heyliot.com)
 */

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

    public function setUp(): void
    {
        $this->client = static::createClient();
        $this->userRepository = self::getContainer()->get('doctrine')->getRepository(User::class);
    }
    /**
     * @dataProvider availableIndexProvider
     *
     * @param string $crudFqcn
     * @param string $expectedPageTitle
     */
    public function testAvailability(string $crudFqcn, string $expectedPageTitle)
    {
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

        $testUser = $this->userRepository->findOneBy(['email' => 'admin@admin.com']);

        $this->client->loginUser($testUser);

        $crawler = $this->client->request('GET', $route);

        $this->assertResponseIsSuccessful();

        $pageTitle = $crawler->filter('h1.title')->first()->text();
        $pageTitle = trim(str_replace("\n", "", $pageTitle));

        $this->assertEquals($expectedPageTitle, $pageTitle);
    }

    public function availableIndexProvider()
    {
        yield [UserCrudController::class, "User"];
    }
}