<?php

namespace App\Repository;

use App\Entity\Filter;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;
class FilterRepository extends NestedTreeRepository
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, $em->getClassMetadata(Filter::class));
    }

    public function findRootNodes(): array
    {
        return $this->findBy(['parent' => null]);
    }

}
