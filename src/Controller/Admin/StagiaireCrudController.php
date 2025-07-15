<?php

namespace App\Controller\Admin;

use App\Entity\Stagiaire;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class StagiaireCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Stagiaire::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nom', 'Nom'),
            TextField::new('prenom', 'Prénom'),
            TextField::new('email', 'Email'),
            TextField::new('diplome', 'Dernier Diplome'),
            AssociationField::new('formation', 'Formation'),
            BooleanField::new('prerequis_valide', 'Test de prérequis valide'),
        ];
    }
}
