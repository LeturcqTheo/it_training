<?php

namespace App\Controller\Admin;

use App\Entity\Evaluation;
use App\Form\QuestionType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class EvaluationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Evaluation::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nom', 'Nom'),
            ChoiceField::new('categorie', 'Catégorie')
                ->setChoices([
                    'Prérequis' => 'prerequis',
                    'Final' => 'final',
                ]),
            CollectionField::new('questions', 'Questions')
                ->setEntryType(QuestionType::class)
                ->allowAdd()
                ->allowDelete()
                ->renderExpanded(),
        ];
    }
}
