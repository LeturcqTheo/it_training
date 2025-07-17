<?php

namespace App\Controller\Admin;

use App\Entity\CentreFormation;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CentreFormationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CentreFormation::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Centre de formation')
            ->setEntityLabelInPlural('Centre de formations');
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
