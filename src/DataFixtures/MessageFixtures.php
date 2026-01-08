<?php

namespace App\DataFixtures;

use App\Entity\Message;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use function PHPUnit\Framework\throwException;

class MessageFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; $i++) {

            $message = new Message()->setTitre('kevin ' . $i)->setMessage('Bonjour Fixtire ' . $i);
            $manager->persist($message);

            $manager->flush();
        }
    }
}
