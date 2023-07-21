<?php

namespace App\DataFixtures;

use App\Entity\Trick;
use App\Entity\Commentaire;
use App\Entity\Utilisateur;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CommentaireFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $trickRepository = $manager->getRepository(Trick::class);
        $utilisateurRepository = $manager->getRepository(Utilisateur::class);

        $utilisateur = $utilisateurRepository->findOneBy(['username' => 'admin']);

        $tricks = $trickRepository->findAll();

        foreach($tricks as $trick) {

            for($i = 0; $i <= rand(1, 30); $i++) {

                $commentaire = new Commentaire();

                $commentaire
                    ->setContent('Commentaire ' . $i)
                    ->setCreatedAt(new \DateTime())
                    ->setUpdatedAt(new \DateTime())
                    ->setAuteur($utilisateur)
                ;

                $trick->addCommentaire($commentaire);
                $manager->persist($commentaire);
            }
            $manager->persist($trick);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            TrickFixtures::class,
        ];
    }
}
