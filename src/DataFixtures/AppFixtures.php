<?php

namespace App\DataFixtures;

use App\Entity\Formateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }


    public function load(ObjectManager $manager): void
    {
        // Un formateur, qui hérite d'un User
        $formateur = new Formateur();
        $formateur->setEmail('formateur@example.com');
        $formateur->setRoles(['ROLE_FORMATEUR']);
        $formateur->setNom('Dupont');
        $formateur->setPrenom('Jean');
        $formateur->setCv('cv_jean_dupont.pdf');
        $formateur->setEstValide(true);

        $hashedPassword = $this->hasher->hashPassword($formateur, 'motdepasse123');
        $formateur->setPassword($hashedPassword);

        $manager->persist($formateur);



        // :D
        $manager->flush();
    }
}
