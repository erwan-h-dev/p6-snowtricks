<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CategorieFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for($i = 0; $i <= 5; $i++) {

            $categorie = new Categorie();

            $categorie->setLibelle('Catégorie ' . $i);

            $manager->persist($categorie);
        }

        $manager->flush();
    }
}
