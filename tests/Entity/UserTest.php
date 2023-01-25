<?php

namespace App\Tests;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testUserOk()
    {
    $user = new User('un nouveau utilisateur',User::class,'mot de passe',);
    }
}
