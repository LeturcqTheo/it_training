<?php

namespace App\Controller\Admin;

use App\Entity\Formation;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class FormationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Formation::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nom', 'Nom'),
            ChoiceField::new('type', 'Type de formation')
                ->setChoices([
                    'Inter' => 'inter',
                    'Intra' => 'intra',
                ]),
            MoneyField::new('prix', 'Prix')->setCurrency('EUR'),
            AssociationField::new('sousthemes', 'Sous-Thèmes'),
            TextEditorField::new('fiche_formation', 'Fiche Formation'),
        ];
    }
}
