<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Entity\Salle;
use App\Entity\Session;
use App\Repository\SalleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/create-event', name: 'create_event', methods: ['POST'])]
    public function createEvent(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $requiredFields = ['nom', 'date_debut', 'date_fin'];

        // Check for required fields
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                return new JsonResponse(['error' => 'Tous les champs sont obligatoires.'], 400);
            }
        }

        // Parse dates
        try {
            $start = new \DateTimeImmutable($data['date_debut']);
            $end = new \DateTimeImmutable($data['date_fin']);
        } catch (\Exception) {
            return new JsonResponse(['error' => 'Dates invalides.'], 400);
        }

        // Optional salle
        $salle = null;
        if (!empty($data['salle_id'])) {
            $salle = $em->getRepository(Salle::class)->find($data['salle_id']);
            if (!$salle) {
                return new JsonResponse(['error' => 'Salle introuvable.'], 404);
            }
        }

        // Create and save event
        $event = (new Evenement())
            ->setNom($data['nom'])
            ->setResponsable('Test')
            ->setNbrParticipant(2)
            ->setDateDebut($start)
            ->setDateFin($end)
            ->setSalle($salle);

        $em->persist($event);
        $em->flush();

        return new JsonResponse(['success' => true, 'id' => $event->getId()]);
    }
    
}
