<?php

namespace App\Controller\Admin;

use App\Entity\Affecte;
use App\Entity\CentreFormation;
use App\Entity\Checklist;
use App\Entity\Evaluation;
use App\Entity\Evenement;
use App\Entity\FichePresence;
use App\Entity\Formateur;
use App\Entity\Formation;
use App\Entity\FormSatisfaction;
use App\Entity\Mail;
use App\Entity\Note;
use App\Entity\Salle;
use App\Entity\Session;
use App\Entity\SousTheme;
use App\Entity\Stagiaire;
use App\Entity\Theme;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function index(): Response
    {
        return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // 1.1) If you have enabled the "pretty URLs" feature:
        // return $this->redirectToRoute('admin_user_index');
        //
        // 1.2) Same example but using the "ugly URLs" that were used in previous EasyAdmin versions:
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirectToRoute('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('It-Training');
    }

    public function configureMenuItems(): iterable
    {
        //yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::section('Formation & Thèmes');
        yield MenuItem::linkToCrud('Formations', 'fas fa-book-open', Formation::class);
        yield MenuItem::linkToCrud('Thèmes', 'fas fa-lightbulb', Theme::class);
        yield MenuItem::linkToCrud('Sous-Themes', 'fas fa-layer-group', SousTheme::class);

        yield MenuItem::section('Sessions & Événements');
        yield MenuItem::linkToCrud('Evenements', 'fas fa-calendar', Evenement::class);
        yield MenuItem::linkToCrud('Sessions', 'fas fa-calendar-alt', Session::class);
        yield MenuItem::linkToCrud('Checklists', 'fas fa-check-square', Checklist::class);

        yield MenuItem::section('Formateurs & Stagiaires');
        yield MenuItem::linkToCrud('Stagiaires', 'fas fa-users', Stagiaire::class);
        yield MenuItem::linkToCrud('Formateurs', 'fas fa-chalkboard-teacher', Formateur::class);
        yield MenuItem::linkToCrud('Affectations', 'fas fa-user-tag', Affecte::class);
        
        yield MenuItem::section('Comptes Utilisateurs');
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-user', User::class);

        yield MenuItem::section('Présences & Évaluations');
        yield MenuItem::linkToCrud('Fiches de présence', 'fas fa-file-signature', FichePresence::class);
        yield MenuItem::linkToCrud('Evaluations', 'fas fa-clipboard-check', Evaluation::class);
        yield MenuItem::linkToCrud('Formulaires de satisfaction', 'fas fa-smile', FormSatisfaction::class);
        yield MenuItem::linkToCrud('Notes', 'fas fa-sticky-note', Note::class);
        
        yield MenuItem::section('Salles & Centres');
        yield MenuItem::linkToCrud('Salles', 'fas fa-door-open', Salle::class);
        yield MenuItem::linkToCrud('Centres de formations', 'fas fa-school', CentreFormation::class);

        yield MenuItem::section('Communication');
        yield MenuItem::linkToCrud('Mails', 'fas fa-envelope', Mail::class);


    }
}
