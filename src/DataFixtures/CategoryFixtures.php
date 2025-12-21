<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $listeCategory = ['Batman', 'Sun ken rock', 'Superman'];
        foreach ($listeCategory as $nom) {
            $category = new Category();
            $category->setNom($nom);
            $category->setSlug($nom);
            $manager->persist($category);
        }
        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['group_category'];
    }
}
