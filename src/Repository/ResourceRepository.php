<?php

namespace App\Repository;

use App\Entity\Resource;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;
class ResourceRepository extends NestedTreeRepository
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, $em->getClassMetadata(Resource::class));
    }

    public function findRootNodes(): array
    {
        return $this->findBy(['parent' => null]);
    }


   public function getResources(?int $id = null): array
    {
        $q = $this->createQueryBuilder('f')
            ->select('f.id', 'f.title')
            ->where('f.parent IS NULL')
            ->orderBy('f.id', 'ASC');

        if ($id !== null) {
            $q->andWhere('f.id = :id')->setParameter('id', $id);
        }

        return $q
            ->getQuery()
            ->getArrayResult();
    }

}
