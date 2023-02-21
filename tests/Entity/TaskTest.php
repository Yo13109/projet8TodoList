<?php

namespace App\Tests\Entity;

use App\Entity\Task;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TaskTest extends KernelTestCase
{
    public function testEntityValid(): void
    {
        self::bootKernel();
        $container = static::getContainer();
        $user = new User;
        $task = new Task;

        $task->setContent('Content 1')
            ->setTitle('Titre 1')
            ->setIsDone(true)
            ->setCreatedAt(new \DateTimeImmutable)
            ->setUser($user);

        $error = $container->get('validator')->validate($task);
        $this->assertCount(0,$error);
    }
}
