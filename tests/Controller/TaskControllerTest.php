<?php

namespace App\Tests\Controller;

use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\component\HttpFoundation\Response;
use App\Repository\UserRepository;

class TaskControllerTest extends WebTestCase
{
    public function testCreateTask(): void
    {
        $client = static::createClient();
        $client->request('POST', '/createtask', [
            'title' => 'Projet 13',
            'Content' => 'Je Suis bientot là'
        ],);

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
    public function testListTask(): void
    {
        $client = static::createClient();
        $client->request('GET', '/tasklist',);

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
    public function testListTaskListDone(): void
    {
        $client = static::createClient();
        $client->request('GET', '/tasklistdone',);

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
    public function testDeleteTask(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('yoann.corsi@gmail.com');
        $client->loginUser($testUser);
        $taskRepository = static::getContainer()->get(TaskRepository::class);
        $testTask = $taskRepository->findOneByTitle('Projet 4');
        $id = $testTask->getId();
        dump($id);
        

        $client->request('GET', "/tasks/{$id}/delete",);

        $client->followRedirect();
        $this->assertSelectorTextContains('h6', "yoann.corsi@gmail.com");
        $testTask = $taskRepository->findOneByTitle('Projet 4');
        dump($testTask);
    }
   public function testEditTask(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('yoann.corsi@gmail.com');
        $client->loginUser($testUser);
        $taskRepository = static::getContainer()->get(TaskRepository::class);
        $testTask = $taskRepository->findOneByTitle('Projet 8');
        $id =$testTask->getId();


        $crawler = $client->request('GET', "/tasks/{$id}/edit");
        $buttonCrawlerNode = $crawler->selectButton('Modifier');
        $form = $buttonCrawlerNode->form();
        $client->submit($form, [
            'task[title]'    => 'projet 8',
            'task[content]' => 'Finir Les Tests!',

        ]);

        $client->followRedirect();
        $this->assertSelectorTextContains('h6', "yoann.corsi@gmail.com");
    }
    public function testToggleTask(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('yoann.corsi@gmail.com');
        $client->loginUser($testUser);
        $taskRepository = static::getContainer()->get(TaskRepository::class);
        $testTask = $taskRepository->findOneByTitle('Projet 8');
        $id = $testTask->getId();

        $crawler = $client->request('GET', "/tasks/{$id}/toggle");



        $client->followRedirect();
        $this->assertSelectorTextContains('h6', "yoann.corsi@gmail.com");
    }
   /* public function testEditTaskFalse(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('yoann.corsi@gmail.com');
        $client->loginUser($testUser);
        $taskRepository = static::getContainer()->get(TaskRepository::class);
        $testTask = $taskRepository->findOneByTitle('Projet 3');
        $id =$testTask->getId();


        $crawler = $client->request('GET', "/tasks/{$id}/edit");
        $buttonCrawlerNode = $crawler->selectButton('Modifier');
        $form = $buttonCrawlerNode->form();
        $client->submit($form, [
            'task[title]'    => 'projet 3',
            'task[content]' => 'Finir LE CHAMPIONNAT',

        ]);

        $client->followRedirect();
        $this->assertSelectorTextContains('h6', "yoann.corsi@gmail.com");
    }*/
    public function testDeleteTaskAnonyme(): void
    {
       $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('yoann.corsi@gmail.com');
        $client->loginUser($testUser);
        $taskRepository = static::getContainer()->get(TaskRepository::class);
        $testTask = $taskRepository->findOneByTitle('Projet 1');
        $id = $testTask->getId();


        $client->request('GET', "/tasks/{$id}/delete",);

        $client->followRedirect();
        $this->assertSelectorTextContains('h6', "yoann.corsi@gmail.com");
    }
   public function testDeleteTaskOther(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('yoann.corsi@gmail.com');
        $client->loginUser($testUser);
        $taskRepository = static::getContainer()->get(TaskRepository::class);
        $testTask = $taskRepository->findOneByTitle('Projet 3');
        $id = $testTask->getId();


    $client->request('GET', "/tasks/{$id}/delete",);

        $client->followRedirect();
        $this->assertSelectorTextContains('h6', "yoann.corsi@gmail.com");
    }
}
