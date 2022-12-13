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
                'roles'=> ['ROLE_ADMIN']
            ],
            2 => [
                'email' => 'laura.corsi@gmail.com',
                'password' => 'Laura13109',
                'roles'=> []
            ],
            3 => [
                'email' => 'elodie.corsi@gmail.com',
                'password' => 'Elodie13109',
                'roles'=> []
            ],
           
                
           
           
        ];

        foreach ($datas as $key => $userdatas) {
            $user = new User();
            $user
                ->setEmail($userdatas['email'])
                ->setPassword($this->passwordHasher->hashPassword($user,$userdatas['password']))
                ->setRoles($userdatas['roles']);
                $this->addReference('user' . $key, $user);              
                    $manager->persist($user);
                }
        $manager->flush();
    }
}