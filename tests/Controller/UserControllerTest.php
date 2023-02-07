<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
Use Symfony\component\HttpFoundation\Response;

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
       // $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        /*$userRepository = $client->getContainer()->get(UserRepository::class);
        $user = $userRepository->findBy([]);

        $client ->loginUser($user);
        $client->request('GET','/logout');
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        $client->followRedirect();

        $this->assertRouteSame('/');
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);*/

        $this->assertEquals(2,2);
       
       
        
    }
     public function testLoginfauxidentifiants()
    {
        $client = static::createClient();
        $client->request('POST','/login',[
            'email'=>'yoann.corsi@gmail.com',
            'password' => 'Yoann13',
        ]);
        $this->assertResponseRedirects('/login');
        $client->followRedirect();
        $this->assertSelectorExists('.alert.alert-danger');
        
        
    }
    public function testLoginVraiIdentifiants()
    {
        $client = static::createClient();
        $client->request('POST','/login',[
            'email'=>'yoann.corsi@gmail.com',
            'password' => 'Yoann13109',
        ]);
        $this->assertResponseRedirects('');
            
    }
    public function test()
    {
        $client = static::createClient();
        $client->request('POST','/login',[
            'email'=>'yoann.corsi@gmail.com',
            'password' => 'Yoann13109',
        ]);
        $this->assertResponseRedirects('');
            
    }

}
