<?php

namespace App\Controller\Admin;

use App\Entity\Mail;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class MailCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Mail::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nom_prenom', "Nom de l'éxpediteur"),
            TextField::new('expediteur', "Adresse de l'éxpediteur"),
            TextField::new('destinataire', "Adresse du destinataire"),
            TextField::new('status', "Status"),
            TextEditorField::new('contenu', 'Contenu'),
            AssociationField::new('user', 'Utilisateur associé'),
        ];
    }

}
