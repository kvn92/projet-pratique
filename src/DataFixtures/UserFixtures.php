<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements FixtureGroupInterface
{


    public function __construct(private UserPasswordHasherInterface $hasher) {}

    public function load(ObjectManager $manager): void
    {


        for ($i = 0; $i < 10; $i++) {

            $rolesOptions = [['ROLE_ADMIN', 'ROLE_USER'], ['ROLE_USER']];
            $randomRoles = $rolesOptions[rand(0, 1)];

            $user = new User();
            $password = $this->hasher->hashPassword($user, 'test' . $i);

            $user->setUsername('user' . $i);
            $user->setEmail('user' . $i . '@test.com');
            $user->setPassword($password);
            $user->setRoles($randomRoles);


            $manager->persist($user);
            $manager->flush();
        }
        // $product = new Product();
        // $manager->persist($product);


    }

    public static function getGroups(): array
    {
        return ['group_user'];
    }
}
