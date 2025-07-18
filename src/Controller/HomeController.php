<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Entity\Session;
use App\Repository\SalleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(SalleRepository $salleRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'salles' => $salleRepository->findAll(),
        ]);
    }

    
    #[Route('/evenement/{id}', name: 'evenement_show')]
    public function showEvenement(Evenement $evenement): Response
    {
        return $this->render('home/evenement.html.twig', [
            'evenement' => $evenement,
        ]);
    }

    #[Route('/session/{id}', name: 'session_show')]
    public function showSession(Session $session): Response
    {
        return $this->render('home/session.html.twig', [
            'session' => $session,
        ]);
    }
    
}
