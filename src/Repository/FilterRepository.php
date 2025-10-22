<?php

namespace App\Repository;

use App\Entity\Filter;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;
class FilterRepository extends NestedTreeRepository
{
    public function findRootNodes(): array
    {
        return $this->findBy(['parent' => null]);
    }

}
