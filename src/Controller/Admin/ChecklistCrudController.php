<?php

namespace App\Controller\Admin;

use App\Entity\Checklist;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;

class ChecklistCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Checklist::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('session', 'Session'),
            BooleanField::new('salle', 'Salle'),
            BooleanField::new('machines', 'Machine'),
            BooleanField::new('supports', 'Supports'),
            BooleanField::new('formulaire', 'Formulaire'),
            BooleanField::new('fichePresence', 'Fiche de presence'),
            BooleanField::new('ticketsRepas', 'Tickets Repas'),
        ];
    }
}
