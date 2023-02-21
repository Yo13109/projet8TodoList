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
    //  public function testLoginfauxidentifiants()
    // {
    //   $client = static::createClient();
    // $client->request('POST','/login',[
    //   'email'=>'yoann.corsi@gmail.com',
    // 'password' => 'Yoann13',
    //]);
    //$this->assertResponseRedirects('/login');
    // $client->followRedirect();
    // $this->assertSelectorExists('.alert.alert-danger');


    //}
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

        // $client = static::createClient();
        //$crawler = $client->request('GET', '/post/hello-world');

        // select the button
        //$buttonCrawlerNode = $crawler->selectButton('submit');

        // retrieve the Form object for the form belonging to this button
        //$form = $buttonCrawlerNode->form();

        // set values on a form object
        //$form['my_form[name]'] = 'Fabien';
        //$form['my_form[subject]'] = 'Symfony rocks!';

        // submit the Form object
        //$client->submit($form);

        // optionally, you can combine the last 2 steps by passing an array of
        // field values while submitting the form:
        //$client->submit($form, [
        //  'my_form[name]'    => 'Fabien',
        //'my_form[subject]' => 'Symfony rocks!',
        //]);

    }
    // public function testCreateTask()
    //{
    //  $client = static::createClient();
    //$crawler = $client->request('GET', '/createtask');
    //$buttonCrawlerNode = $crawler->selectButton('submit');
    //$form = $buttonCrawlerNode->form();
    //$client->submit($form, [
    //  'my_form[title]'    => 'projet 11',
    //'my_form[content]' => 'Symfony rocks!',
    //'my_form[user]' => 'yoann.corsi@gmail.com',
    //'my_form[isDone]' => 1,
    //'my_form[createdAt]' => \DateTimeImmutable::class,


    //]);
    //$client->submit($form);

    //$this->assertResponseStatusCodeSame(Response::HTTP_OK);

    //}

    //public function testCreateUser(): void
    //{
    //  $client = static::createClient();
    //$crawler = $client->request('GET', '/inscription');
    //$buttonCrawlerNode = $crawler->selectButton('submit');
    //$form = $buttonCrawlerNode->form();
    //$client->submit($form, [
    //   'my_form[email]'    => 'yoann13@gmail.com',
    // 'my_form[password]' => 'Yoann13109',


    //]);
    // $client->submit($form);

    //   $this->assertResponseStatusCodeSame(Response::HTTP_OK);

    //  }

}
