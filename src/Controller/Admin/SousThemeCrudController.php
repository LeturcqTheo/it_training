<?php

namespace App\Controller\Admin;

use App\Entity\SousTheme;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SousThemeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SousTheme::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Sous-Thème')
            ->setEntityLabelInPlural('Sous-Thèmes');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('intitule', 'Intitulé'),
            AssociationField::new('theme', 'Thème'),
        ];
    }
}
