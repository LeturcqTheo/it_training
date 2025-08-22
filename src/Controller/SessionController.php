<?php

namespace App\Controller;

use App\Entity\Affecte;
use App\Entity\Checklist;
use App\Entity\Evenement;
use App\Entity\Formateur;
use App\Entity\Formation;
use App\Entity\Salle;
use App\Entity\Session;
use App\Repository\AffecteRepository;
use App\Repository\CentreFormationRepository;
use App\Repository\ChecklistRepository;
use App\Repository\EvenementRepository;
use App\Repository\FormateurRepository;
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

final class SessionController extends AbstractController
{
    #[Route('/', name: 'app_sessions')]
    public function index(SalleRepository $salleRepository, CentreFormationRepository $centreRepo): Response
    {
        return $this->render('session/index.html.twig', [
            'salles' => $salleRepository->findAll(),
            'centres' => $centreRepo->findAll(),
        ]);
    }
    
    #[Route('/evenement/{id}', name: 'app_show_event')]
    public function showEvenement(Evenement $evenement): Response
    {
        return $this->render('session/evenements/show.html.twig', [
            'evenement' => $evenement,
        ]);
    }

    #[Route('/session/{id}', name: 'app_show_session')]
    public function showSession(Session $session, AffecteRepository $affecteRepo, FormateurRepository $formaRepo, StagiaireRepository $stagRepo): Response
    {
        $affectation = $affecteRepo->findOneBy(['session' => $session]);
        $stagiairesCompatibles = $stagRepo->findBy(['formation' => $session->getFormation()]);

        return $this->render('session/sessions/show.html.twig', [
            'session' => $session,
            'affectation' => $affectation,
            'formateurs' => $formaRepo,
            'stagiaires' => $stagiairesCompatibles,
        ]);
    }


    #[Route('/create-event', name: 'app_create_event')]
    public function showCreateEvent(SalleRepository $salleRepository, CentreFormationRepository $centreRepo): Response
    {
        return $this->render('session/evenements/create.html.twig', [
            'salles' => $salleRepository->findAll(),
            'centres' => $centreRepo->findAll(),
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
    public function showCreateSession(SalleRepository $salleRepository, FormationRepository $formaRepository, StagiaireRepository $stagRepository, CentreFormationRepository $centreRepo, FormateurRepository $formaRepo): Response
    {
        return $this->render('session/sessions/create.html.twig', [
            'salles' => $salleRepository->findAll(),
            'formations' => $formaRepository->findAll(),
            'stagiaires' => $stagRepository->findAll(),
            'centres' => $centreRepo->findAll(),
            'formateurs' => $formaRepo->findAll(),
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
        $formateur = $em->getRepository(Formateur::class)->find($data['formateur_id']);

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

        if ($formateur != null) {
            $affectation = (new Affecte())
                ->setSession($session)
                ->setFormateur($formateur)
                ->setConfirmePresence(false);

            $em->persist($affectation);
        }

        $em->flush();

        return new JsonResponse(['success' => true, 'id' => $session->getId()]);
    } 

    #[Route('/session/{id}/assign-formateur', name: 'assign_formateur_to_session', methods: ['POST'])]
    public function assignFormateur(Session $session, Request $request, FormateurRepository $formateurRepo, EntityManagerInterface $em): Response
    {
        $formateurId = $request->request->get('formateur_id');
        $formateur = $formateurRepo->find($formateurId);

        if (!$formateur) {
            $this->addFlash('error', 'Formateur non trouvé.');
            return $this->redirectToRoute('app_show_session', ['id' => $session->getId()]);
        }

        $affectation = (new Affecte())
            ->setSession($session)
            ->setFormateur($formateur)
            ->setConfirmePresence(false);

        $em->persist($affectation);
        $em->flush();

        $this->addFlash('success', 'Formateur affecté avec succès.');
        return $this->redirectToRoute('app_show_session', ['id' => $session->getId()]);
    }


    #[Route('/session/{id}/update-stagiaires', name: 'update_stagiaires_for_session', methods: ['POST'])]
    public function updateStagiaires(Session $session, Request $request, StagiaireRepository $stagRepo, EntityManagerInterface $em): Response
    {
        $selectedIds = $request->get('stagiaires', []);
        $stagiaires = [];

        foreach ($selectedIds as $id) {
            $stagiaire = $stagRepo->find($id);
            if ($stagiaire) {
                $stagiaires[] = $stagiaire;
            }
        }

        // Remove existing
        foreach ($session->getStagiaires() as $existing) {
            $session->removeStagiaire($existing);
        }

        // Add new ones
        foreach ($stagiaires as $stagiaire) {
            $session->addStagiaire($stagiaire);
        }

        $em->persist($session);
        $em->flush();

        $this->addFlash('success', 'Liste des stagiaires mise à jour.');
        return $this->redirectToRoute('app_show_session', ['id' => $session->getId()]);
    }
    
    #[Route('/session/{id}/update-checklist', name: 'update_checklist', methods: ['POST'])]
    public function updateChecklist(int $id, Request $request, EntityManagerInterface $em): Response
    {
        $session = $em->getRepository(Session::class)->find($id);

        if (!$session) {
            throw $this->createNotFoundException('Session non trouvée.');
        }

        $checklist = $session->getChecklist();

        if (!$checklist) {
            $checklist = new Checklist();
            $checklist->setSession($session);
            $em->persist($checklist);
        }

        // Pour chaque case, on vérifie si elle est cochée (clé présente dans POST)
        $checklist->setSalle($request->request->has('salle'));
        $checklist->setMachines($request->request->has('machines'));
        $checklist->setSupports($request->request->has('supports'));
        $checklist->setFormulaire($request->request->has('formulaire'));
        $checklist->setFichePresence($request->request->has('fichePresence'));
        $checklist->setTicketsRepas($request->request->has('ticketsRepas'));

        $em->flush();

        $this->addFlash('success', 'Checklist mise à jour avec succès.');

        return $this->redirectToRoute('app_show_session', ['id' => $session->getId()]);
    }

}
