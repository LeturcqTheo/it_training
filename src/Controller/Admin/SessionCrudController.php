<?php

namespace App\Controller\Admin;

use App\Entity\Session;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;

class SessionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Session::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('formation', 'Formation'),
            AssociationField::new('salle', 'Salle'),
            IntegerField::new('min_participant', 'N° minimum de participant'),
            MoneyField::new('prix', 'Prix')->setCurrency('EUR'),
            DateTimeField::new('date_debut', 'Date début'),
            DateTimeField::new('date_fin', 'Date fin'),
            AssociationField::new('stagiaires', 'Stagiaires'),
        ];
    }
}
