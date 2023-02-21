<?php


namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
Use Symfony\component\HttpFoundation\Response;

class HomeControllerTest extends WebTestCase
{
    public function testHelloPage(): void
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorTextContains('h1', "Bienvenue sur Todo List, l'application vous permettant de gérer l'ensemble de vos tâches sans effort !");
    }

    
}
