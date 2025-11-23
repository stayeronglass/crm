<?php
namespace App\Validator;

use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class EventPriorityValidator extends ConstraintValidator
{


    public function __construct(private readonly EventRepository $repository)
    {
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof EventPriority) {
            throw new UnexpectedTypeException($constraint, EventPriority::class);
        }

        // custom constraints should ignore null and empty values to allow
        // other constraints (NotBlank, NotNull, etc.) to take care of that
        if (null === $value || '' === $value) {
            return;
        }

//        $events = $this->repository->createQueryBuilder('c')
//            ->innerJoin('c.service', 's')
//            ->andWhere('c.dateBegin < :dateEnd')
//            ->andWhere('c.dateEnd > :dateBegin')
//            ->andWhere('s.priority > :priority')
//            ->andWhere('c.resource = :resource')
//            ->setParameter('dateBegin', $value->getDateBegin())
//            ->setParameter('dateEnd', $value->getDateEnd())
//            ->setParameter('priority', $value->getService()->getPriority())
//            ->setParameter('resource', $value->getResource())
//            ->setMaxResults(1)
//            ->getQuery()
//            ->getResult()
//        ;

        if (!empty($events)) {
            $this->context
                ->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
