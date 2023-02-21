<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
Use Symfony\component\HttpFoundation\Response;

class TaskControllerTest extends WebTestCase
{
    public function testCreateTask(): void
    {
        $client = static::createClient();
        $client->request('POST','/createtask',[
            'title'=>'Projet 13',
            'Content' => 'Je Suis bientot là'],);

            $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    
    }
    public function testListTask(): void
    {
        $client = static::createClient();
        $client->request('GET','/tasklist',);

            $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    
    }
   // public function testDeleteTask(): void
    //{
      //  $client = static::createClient();
      // $client->request('Get','/tasks/135/delete',);
            
        //    $this->assertResponseIsSuccessful();
    
   //}
}
