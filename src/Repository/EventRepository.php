<?php

namespace App\Repository;

use App\Entity\Event;
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


    public function getEvents(): array
    {
        return $this->createQueryBuilder('event')
            ->select(
                'e.id as id',
                'e.dateBegin as start',
                'e.dateEnd as end',
                'e.comment as title',
            )
            ->from('App\Entity\Event', 'e')
            ->addOrderBy('event.id', 'ASC')
            ->getQuery()
            ->getArrayResult();
    }
}
