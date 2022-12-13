<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Task;

class TaskFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $datas = [
            1 => [
                'title' => 'Projet 1',
                'content' => "Définissez votre stratégie d'apprentissage",
                'isDone' => 1,
                'user' => null,
            ],
            2 => [
                'title' => 'Projet 2',
                'content' => 'Intégrez un thème Wordpress pour un client',
                'isDone' => 1,
                'user' => null,
                
            ],
            3 => [
                'title' => 'Projet 3',
                'content' => 'Analysez les besoins de votre client pour son festival de films',
                'isDone' => 1,
                'user' => 3,
            ],
            4 =>  [
                'title' => 'Projet 4',
                'content' => "Concevez la solution technique d'une application de restauration en ligne, ExpressFood",
                'isDone' => 1,
                'user' => 1,
            ],
            5 =>  [
                'title' => 'Projet 5',
                'content' => 'Créez votre premier blog en PHP',
                'isDone' => 1,
                'user' => 3,
            ],
            6 =>  [
                'title' => 'Projet 6',
                'content' => 'Développez de A à Z le site communautaire SnowTricks',
                'isDone' => 1,
                'user' => 3,
            ],
            7 => [
                'title' => 'Projet 7',
                'content' => 'Créez un web service exposant une API',
                'isDone' => 1,
                'user' => 2,
            ],
            8 => [
                'title' => 'Projet 8',
                'content' => 'Améliorez une application existante de ToDo & Co',
                'isDone' => 0,
                'user' => 1,
            ],
            9 => [
                'title' => 'Projet 9',
                'content' => 'Construisez une veille technologique et (optionnel) effectuez un stage',
                'isDone' => 0,
                'user' => 1,
                
            ],
           
        ];

        foreach ($datas as $key => $taskdatas) {
            $task = new Task();
            $user = $this->getReference('user'. $taskdatas['user']);
            $task
                ->setTitle($taskdatas['title'])
                ->setCreatedAt(new \DateTimeImmutable)
                ->setContent($taskdatas['content'])
                ->setIsDone($taskdatas['isDone'])
                ->setUser($user);
                
            $manager->persist($task);
        }
        

        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}
