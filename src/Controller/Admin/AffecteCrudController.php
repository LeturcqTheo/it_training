<?php

namespace App\Controller\Admin;

use App\Entity\Affecte;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;

class AffecteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Affecte::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Affectation')
            ->setEntityLabelInPlural('Affectations');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('formateur', 'Formateur'),
            AssociationField::new('session', 'Session'),
            BooleanField::new('confirme_presence', 'Présense confirmé'),
        ];
    }
}
