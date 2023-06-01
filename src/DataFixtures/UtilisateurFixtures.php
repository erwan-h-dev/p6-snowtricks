<?php

namespace App\DataFixtures;

use App\Entity\Utilisateur;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UtilisateurFixtures extends Fixture
{

    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $utilisateur = new Utilisateur();
        $utilisateur->setUserName('admin')
            ->setEmail('')
            ->setPassword($this->hasher->hashPassword($utilisateur, 'password'))
            ->setRoles(['ROLE_USER', 'ROLE_ADMIN'])
        ;
        
        $manager->persist($utilisateur);
        $manager->flush();
    }
}
