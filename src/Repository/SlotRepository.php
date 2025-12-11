<?php

namespace App\Repository;

use App\Entity\Slot;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Slot>
 */
class SlotRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Slot::class);
    }
    public function getSlots(?string $dateStart, ?string $dateEnd): array
    {

        $q = $this->createQueryBuilder('slot')
            ->select(
                'slot'
            )
            ->addOrderBy('slot.id', 'ASC');

        if ($dateStart !== null) {
            $dateStart = DateTime::createFromFormat('Y-m-d\TH:i:s' , $dateStart);
            $q->andWhere('slot.dateBegin >= :start')
                ->setParameter('start', $dateStart);
        }

        if ($dateEnd !== null) {
            $dateEnd = DateTime::createFromFormat('Y-m-d\TH:i:s' , $dateEnd);
            $q->andWhere('slot.dateEnd <= :end')
                ->setParameter('end', $dateEnd);

        }
        return $q->getQuery()
            ->getResult();
    }
}
