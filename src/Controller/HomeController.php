<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Entity\Formation;
use App\Entity\Salle;
use App\Entity\Session;
use App\Repository\EvenementRepository;
use App\Repository\FormationRepository;
use App\Repository\SalleRepository;
use App\Repository\SessionRepository;
use App\Repository\StagiaireRepository;
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
    
    #[Route('/evenement/{id}', name: 'app_show_event')]
    public function showEvenement(Evenement $evenement): Response
    {
        return $this->render('home/evenements/show.html.twig', [
            'evenement' => $evenement,
        ]);
    }

    #[Route('/session/{id}', name: 'app_show_session')]
    public function showSession(Session $session): Response
    {
        return $this->render('home/sessions/show.html.twig', [
            'session' => $session,
        ]);
    }   

    #[Route('/create-event', name: 'app_create_event')]
    public function showCreateEvent(SalleRepository $salleRepository): Response
    {
        return $this->render('home/evenements/create.html.twig', [
            'salles' => $salleRepository->findAll(),
        ]);
    }

    #[Route('/create-event/create', name: 'create_event', methods: ['POST'])]
    public function createEvent(Request $request, EntityManagerInterface $em, EvenementRepository $eventRepo, SessionRepository $sessionRepo): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $salle = $em->getRepository(Salle::class)->find($data['salle_id']);
        $start = new \DateTimeImmutable($data['date_debut']);
        $end = new \DateTimeImmutable($data['date_fin']);

        if ($start >= $end) {
            return new JsonResponse(['error' => 'La date de fin doit être après la date de début.'], 400);
        }

        $conflicts = $eventRepo->findOverlappingEvents($salle->getId(), $start, $end);
        $conflicts += $sessionRepo->findOverlappingEvents($salle->getId(), $start, $end);

        if (count($conflicts) > 0) {
            return new JsonResponse(['error' => 'La salle est déjà occupée durant cette période.'], 400);
        }

        $event = (new Evenement())
            ->setNom($data['nom'])
            ->setResponsable($data['nom_resp'])
            ->setNbrParticipant((int)$data['nbr_part'])
            ->setDateDebut($start)
            ->setDateFin($end)
            ->setSalle($salle);

        $em->persist($event);
        $em->flush();

        return new JsonResponse(['success' => true, 'id' => $event->getId()]);
    } 

    #[Route('/create-session', name: 'app_create_session')]
    public function showCreateSession(SalleRepository $salleRepository, FormationRepository $formaRepository, StagiaireRepository $stagRepository): Response
    {
        return $this->render('home/sessions/create.html.twig', [
            'salles' => $salleRepository->findAll(),
            'formations' => $formaRepository->findAll(),
            'stagiaires' => $stagRepository->findAll(),
        ]);
    }

    #[Route('/create-session/create', name: 'create_session', methods: ['POST'])]
    public function createSession(Request $request, EntityManagerInterface $em, EvenementRepository $eventRepo, SessionRepository $sessionRepo, StagiaireRepository $stagRepo): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $salle = $em->getRepository(Salle::class)->find($data['salle_id']);
        $formation = $em->getRepository(Formation::class)->find($data['formation_id']);
        $start = new \DateTimeImmutable($data['date_debut']);
        $end = new \DateTimeImmutable($data['date_fin']);

        if ($start >= $end) {
            return new JsonResponse(['error' => 'La date de fin doit être après la date de début.'], 400);
        }

        $conflicts = $eventRepo->findOverlappingEvents($salle->getId(), $start, $end);
        $conflicts += $sessionRepo->findOverlappingEvents($salle->getId(), $start, $end);

        if (count($conflicts) > 0) {
            return new JsonResponse(['error' => 'La salle est déjà occupée durant cette période.'], 400);
        }

        $session = (new Session())
            ->setFormation($formation)
            ->setSalle($salle)
            ->setMinParticipant((int)$data['nbr_part'])
            ->setDateDebut($start)
            ->setDateFin($end);

        // Ajout des stagiaires
        if (!empty($data['stagiaires']) && is_array($data['stagiaires'])) {
            foreach ($data['stagiaires'] as $stagiaireId) {
                $stagiaire = $stagRepo->find($stagiaireId);
                if ($stagiaire) {
                    $session->addStagiaire($stagiaire);
                }
            }
        }

        $em->persist($session);
        $em->flush();

        return new JsonResponse(['success' => true, 'id' => $session->getId()]);
    } 
}
