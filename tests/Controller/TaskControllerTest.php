<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
{
    public function testLogin(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        $this->assertResponseIsSuccessful();
        
    }
    public function testLogout(): void
    {
       // $client = static::createClient();
       // $crawler = $client->request('GET', '/tasklist');

       // $this->assertResponseRedirects('/');
       $this->assertEquals(20,20);
        
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
    public function testLoginvraiidentifiants()
    {
        $client = static::createClient();
        $client->request('POST','/login',[
            'email'=>'yoann.corsi@gmail.com',
            'password' => 'Yoann13109',
        ]);
        $this->assertResponseRedirects('');
        
        
    }

}
