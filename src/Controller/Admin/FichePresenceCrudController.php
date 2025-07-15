<?php

namespace App\Controller\Admin;

use App\Entity\FichePresence;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class FichePresenceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return FichePresence::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Fiche de présence')
            ->setEntityLabelInPlural('Affectations');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('stagiaire', 'Stagiaire'),
            DateTimeField::new('jour', 'Jour'),
            BooleanField::new('est_present', 'Présent'),
            IntegerField::new('retard', 'Retard (en minutes)'),
            
        ];
    }
}
