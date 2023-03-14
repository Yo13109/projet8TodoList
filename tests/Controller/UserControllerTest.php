<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Doctrine\DBAL\Types\DateImmutableType;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\component\HttpFoundation\Response;

class UserControllerTest extends WebTestCase
{
    public function testLogin(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        $this->assertResponseIsSuccessful();
    }
    public function testLogout(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('yoann.corsi@gmail.com');
        $client->loginUser($testUser);
        $client->request('GET', '/logout');
        $client->followRedirect();
        $this->assertSelectorTextContains('h2', "Se connecter");
    }
    public function testLoginfauxidentifiants()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $buttonCrawlerNode = $crawler->selectButton('Se Connecter');
        $form = $buttonCrawlerNode->form();
        $client->submit($form, [
            'email'    => 'yoann.corsi@gmail.com',
            'password' => 'Yoann131',
        ]);
        $client->followRedirect();
        $this->assertSelectorTextContains('h2', "Se connecter");
    }
    public function testLoginVraiIdentifiants()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $buttonCrawlerNode = $crawler->selectButton('Se Connecter');
        $form = $buttonCrawlerNode->form();
        $client->submit($form, [
            'email'    => 'yoann.corsi@gmail.com',
            'password' => 'Yoann13109',
        ]);
        $client->followRedirect();
        $this->assertSelectorTextContains('h6', "yoann.corsi@gmail.com");
    }
    public function testCreateTask()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('yoann.corsi@gmail.com');
        $client->loginUser($testUser);
        $crawler = $client->request('GET', '/createtask');
        $buttonCrawlerNode = $crawler->selectButton('Ajouter');
        $form = $buttonCrawlerNode->form();
        $client->submit($form, [
            'task[title]'    => 'projet 11',
            'task[content]' => 'Symfony rocks!',

        ]);

        $client->followRedirect();
        $this->assertSelectorTextContains('h6', "yoann.corsi@gmail.com");
    }

    public function testCreateUser(): void
    {
        $client = static::createClient();
        $crawler = $client->request('POST', '/inscription');
        $buttonCrawlerNode = $crawler->selectButton("S'inscrire");
        $form = $buttonCrawlerNode->form();
        $client->submit($form, [
            'registration[email]'    => 'yoann.corsi13@gmail.com',
            'registration[password][first]' => 'Giovann13109',
            'registration[password][second]' => 'Giovann13109',
            'registration[roles]'    => 'ROLE_ADMIN'
        ]);

        $client->followRedirect();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
    public function testGestionUtilisateur(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('yoann.corsi@gmail.com');
        $client->loginUser($testUser);


        $crawler = $client->request('GET', '/user/edit');






        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
    public function testAdminChange(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('yoann.corsi@gmail.com');
        $client->loginUser($testUser);

        $testUser2 = $userRepository->findOneByEmail('elodie.corsi@gmail.com');
        $id = $testUser2->getid();


        $client->request('GET', "/user/admin/{$id}");






        $client->followRedirect();
        $this->assertSelectorTextContains('h6', "yoann.corsi@gmail.com");
    }

    public function testUtilisateurChange(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('yoann.corsi@gmail.com');
        $client->loginUser($testUser);

        $testUser2 = $userRepository->findOneByEmail('laura.corsi@gmail.com');
        $id = $testUser2->getid();


        $client->request('GET', "/user/utilisateur/{$id}");






        $client->followRedirect();
        $this->assertSelectorTextContains('h6', "yoann.corsi@gmail.com");
    }
    public function testAccesLoginUtilisateurConnecté(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('yoann.corsi@gmail.com');
        $client->loginUser($testUser);
        $client->request('GET', '/login');
        $client->followRedirect();
        $this->assertSelectorTextContains('h6', "yoann.corsi@gmail.com");
    }
    public function testAccesRegistrationUtilisateurConnecté(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('yoann.corsi@gmail.com');
        $client->loginUser($testUser);
        $client->request('GET', '/inscription');
        $client->followRedirect();
        $this->assertSelectorTextContains('h6', "yoann.corsi@gmail.com");
    }
}
