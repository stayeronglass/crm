<?php
namespace App\Validator;

use App\Repository\EventRepository;
use App\Repository\SlotRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class SlotValidator extends ConstraintValidator
{


    public function __construct(private SlotRepository $repository)
    {
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof Slot) {
            throw new UnexpectedTypeException($constraint, EventPriority::class);
        }

        // custom constraints should ignore null and empty values to allow
        // other constraints (NotBlank, NotNull, etc.) to take care of that
        if (null === $value || '' === $value) {
            return;
        }

        $slots = $this->repository->createQueryBuilder('s')
            ->andWhere('s.dateBegin <= :dateBegin')
            ->andWhere('s.dateEnd >= :dateEnd')
            ->andWhere('s.resource = :resource')
            ->andWhere('s.service = :service')
            ->setParameter('dateBegin', $value->getDateBegin())
            ->setParameter('dateEnd', $value->getDateEnd())
            ->setParameter('resource', $value->getResource())
            ->setParameter('service', $value->getService())
            ->setMaxResults(1)
            ->getQuery()->getResult()
        ;


        if (empty($slots)) {
            $this->context
                ->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
