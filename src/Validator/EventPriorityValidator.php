<?php
namespace App\Validator;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class EventPriorityValidator extends ConstraintValidator
{


    public function __construct(private EntityManagerInterface $entityManager)
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


//        if ($userEmail !== $receiptEmail) {
//            $this->context
//                ->buildViolation($constraint->userDoesNotMatchMessage)
//                ->atPath('user.email')
//                ->addViolation();
//        }
    }
}
