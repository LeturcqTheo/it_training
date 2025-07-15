<?php

namespace App\Controller\Admin;

use App\Entity\FormSatisfaction;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class FormSatisfactionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return FormSatisfaction::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Formulaire de satisfaction')
            ->setEntityLabelInPlural('Formulaires de satisfaction');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('stagiaire', 'Stagiaire'),
            IntegerField::new('note_satisfaction', 'Note de satisfaction'),
            IntegerField::new('note_clarete', 'Note de clareté'),
            TextEditorField::new('problemes', 'Problèmes'),
            TextEditorField::new('suggestions', 'Suggestions'),
            DateTimeField::new('date'),
        ];
    }
}
