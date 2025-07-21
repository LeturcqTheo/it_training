<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Entity\Salle;
use App\Entity\Session;
use App\Repository\EvenementRepository;
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
    public function createEvent(Request $request, EntityManagerInterface $em, EvenementRepository $eventRepo): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $salle = $em->getRepository(Salle::class)->find($data['salle_id']);
        $start = new \DateTimeImmutable($data['date_debut']);
        $end = new \DateTimeImmutable($data['date_fin']);

        if ($start >= $end) {
            return new JsonResponse(['error' => 'La date de fin doit être après la date de début.'], 400);
        }

        $conflicts = $eventRepo->findOverlappingEvents($salle->getId(), $start, $end);

        if (count($conflicts) > 0) {
            return new JsonResponse(['error' => 'La salle est déjà occupée durant cette période.'], 400);
        }

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
