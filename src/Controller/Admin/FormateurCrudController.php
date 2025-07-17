<?php

namespace App\Controller\Admin;

use App\Entity\Formateur;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class FormateurCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Formateur::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nom', 'Nom'),
            TextField::new('prenom', 'Prénom'),
            TextField::new('cv', 'CV'),
            TextField::new('email', 'Email'),
            TextField::new('password', 'Mot de passe'),
            BooleanField::new('est_valide', 'Est validé'),
        ];
    }
}
