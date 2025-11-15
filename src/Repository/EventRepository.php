<?php

namespace App\Repository;

use App\Entity\Event;
use DateTime;
use DateTimeInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Event>
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }


    public function getEvents($dateStart, $dateEnd): array
    {


        $q = $this->createQueryBuilder('event')
            ->select(
                'event'
            )
            ->from('App\Entity\Event', 'e')
            ->addOrderBy('event.id', 'ASC');

        if ($dateStart !== null) {
            $dateStart = DateTime::createFromFormat('Y-m-d\TH:i:s' , $dateStart);
            $q->andWhere('e.dateBegin >= :start')
                ->setParameter('start', $dateStart);
        }

        if ($dateEnd !== null) {
            $dateEnd = DateTime::createFromFormat('Y-m-d\TH:i:s' , $dateEnd);
            $q->andWhere('e.dateEnd <= :end')
                ->setParameter('end', $dateEnd);

        }

        return $q->getQuery()
            ->getResult();
    }
}
