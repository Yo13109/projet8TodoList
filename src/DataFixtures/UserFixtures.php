<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private $passwordHasher;

        public function __construct(UserPasswordHasherInterface $passwordHasher)
        {
            $this->passwordHasher = $passwordHasher;
        }
    public function load(ObjectManager $manager): void
    {
        $datas = [
            1 => [
                'email' => 'yoann.corsi@gmail.com',
                'password' => 'Yoann13109',
            ],
            2 => [
                'email' => 'laura.corsi@gmail.com',
                'password' => 'Laura13109',
            ],
           
                
           
           
        ];

        foreach ($datas as $key => $userdatas) {
            $user = new User();
            $user
                ->setEmail($userdatas['email'])
                ->setPassword($this->passwordHasher->hashPassword($user,$userdatas['password']));
               
                    $manager->persist($user);
                }
        $manager->flush();
    }
}