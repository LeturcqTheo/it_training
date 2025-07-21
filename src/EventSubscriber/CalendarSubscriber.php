<?php

namespace App\EventSubscriber;

use App\Repository\EvenementRepository;
use App\Repository\SessionRepository;
use CalendarBundle\Entity\Event;
use CalendarBundle\Event\SetDataEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class CalendarSubscriber implements EventSubscriberInterface
{
    private EvenementRepository $evenementRepository;
    private SessionRepository $sessionRepository;
    private RequestStack $requestStack;

    public function __construct(EvenementRepository $evenementRepository, SessionRepository $sessionRepository, RequestStack $requestStack)
    {
        $this->evenementRepository = $evenementRepository;
        $this->sessionRepository = $sessionRepository;
        $this->requestStack = $requestStack;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            SetDataEvent::class => 'onCalendarSetData',
        ];
    }

    public function onCalendarSetData(SetDataEvent $setDataEvent): void
    {
        $request = $this->requestStack->getCurrentRequest();
        $salleId = $request->query->get('salle_id');

        $start = $setDataEvent->getStart();
        $end = $setDataEvent->getEnd();

        $qb = $this->evenementRepository->createQueryBuilder('e')
            ->where('e.date_debut BETWEEN :start AND :end OR e.date_fin BETWEEN :start AND :end')
            ->setParameter('start', $start)
            ->setParameter('end', $end);

        if ($salleId !== null && $salleId !== '') {
            $qb->andWhere('e.salle = :salleId')->setParameter('salleId', $salleId);
        }

        $evenements = $qb->getQuery()->getResult();

        foreach ($evenements as $evenement) {
            $event = new Event(
                $evenement->getNom(),
                new \DateTime($evenement->getDateDebut()->format('Y-m-d H:i:s')),
                new \DateTime($evenement->getDateFin()->format('Y-m-d H:i:s'))
            );
            $event->setOptions([
                'backgroundColor' => '#007bff',  // bleu
                'borderColor' => '#007bff',
                'textColor' => '#fff',
            ]);
            $event->addOption('url', 'evenement/' . $evenement->getId());
            $setDataEvent->addEvent($event);
        }

        $qb2 = $this->sessionRepository->createQueryBuilder('s')
            ->where('s.date_debut BETWEEN :start AND :end OR s.date_fin BETWEEN :start AND :end')
            ->setParameter('start', $start)
            ->setParameter('end', $end);
        
        if ($salleId !== null && $salleId !== '') {
            $qb2->andWhere('s.salle = :salleId')->setParameter('salleId', $salleId);
        }

        $sessions = $qb2->getQuery()->getResult();

        foreach ($sessions as $session) {
            $event = new Event(
                (string) $session, // utilise __toString() de Session
                new \DateTime($session->getDateDebut()->format('Y-m-d H:i:s')),
                new \DateTime($session->getDateFin()->format('Y-m-d H:i:s'))
            );
            $event->setOptions([
                'backgroundColor' => '#28a745', // vert
                'borderColor' => '#28a745',
                'textColor' => '#fff',
            ]);
            $event->addOption('url', '/session/' . $session->getId());
            $setDataEvent->addEvent($event);
        }
    }
}
