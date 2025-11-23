<?php
namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class EventPriority extends Constraint
{
    public string $message = 'Нельзя сделать поверх события с большим приоритетом!';
    public string $mode = 'strict';

    // all configurable options must be passed to the constructor
    public function __construct(?string $mode = null, ?string $message = null, ?array $groups = null, $payload = null)
    {
        parent::__construct([], $groups, $payload);

        $this->mode = $mode ?? $this->mode;
        $this->message = $message ?? $this->message;
    }

    public function getTargets(): string
    {
        return self::CLASS_CONSTRAINT;
    }

    public function validatedBy(): string
    {
        return static::class.'Validator';
    }
}
