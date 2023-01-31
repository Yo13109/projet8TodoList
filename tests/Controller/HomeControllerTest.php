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
    }

    
}
