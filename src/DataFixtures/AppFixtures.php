<?php

namespace App\DataFixtures;

use App\Entity\Trick;
use App\Repository\TrickRepository;
use Doctrine\Persistence\ObjectManager;
use App\Repository\UtilisateurRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    // construct
    public function __construct(
        private UtilisateurRepository $utilisateurRepository,
        private TrickRepository $trickRepository
    ) { }

    public function load(ObjectManager $manager): void
    {

        $auteur = $this->utilisateurRepository->find(1);

        for($i=0; $i > 10; $i++){

            $trick = (new Trick())
                ->setTitle('Trick '.$i)
                ->setContent('<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod, nisl quis aliquam luctus, nisl nunc aliquet nunc, nec aliquam nisl nunc quis nisl. Sed euismod, nisl quis aliquam luctus, nisl nunc aliquet nunc, nec aliquam nisl nunc quis nisl.</p>')
                ->setCreatedAt(new \DateTime())
                ->setUpdatedAt(new \DateTime())
                ->setAuteur($auteur)
            ;

            $manager->persist($trick, true);
        }

        $manager->flush();
    }
}
