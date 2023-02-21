<?php

namespace App\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Entity\Task;
use App\Entity\User;

class UserTest extends KernelTestCase
{
    public function testEntityValid(): void
    {
        $kernel = self::bootKernel();

        $container = static::getContainer();
        $user = new User;
        $task = new Task;


        $user->setEmail('yoann.corsi@sfr.fr')
            ->setPassword('Yoann13109')
            ->setRoles(['ROLE_ADMIN'])
            ->addTask($task)
            ;
        $error = $container->get('validator')->validate($user);
        $this->assertCount(0,$error);

        // $routerService = static::getContainer()->get('router');
        // $myCustomService = static::getContainer()->get(CustomService::class);
    }
}
