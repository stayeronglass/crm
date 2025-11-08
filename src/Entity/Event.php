<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\SoftDeleteable\SoftDeleteable;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Timestampable;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event implements Timestampable, SoftDeleteable
{
    use TimestampableEntity, SoftDeleteableEntity;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\NotBlank]
    private ?string $comment;

    #[ORM\Column(type: 'datetimetz_immutable')]
    #[Assert\NotNull]
    #[Assert\NotBlank]
    #[Assert\Type(\DateTimeInterface::class)]
    private \DateTimeImmutable $dateBegin;

    #[ORM\Column(type: 'datetimetz_immutable')]
    #[Assert\NotNull]
    #[Assert\NotBlank]
    #[Assert\Type(\DateTimeInterface::class)]
    private \DateTimeImmutable $dateEnd;

    #[ORM\ManyToOne(targetEntity: Filter::class, cascade: ['persist'], inversedBy: 'eventsService')]
    private Filter $service;

    #[ORM\ManyToOne(targetEntity: Filter::class, cascade: ['persist'], inversedBy: 'eventsPlace')]
    private Filter $place;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): static
    {
        $this->comment = $comment;

        return $this;
    }

    public function getDateBegin(): ?\DateTimeImmutable
    {
        return $this->dateBegin;
    }

    public function setDateBegin(\DateTimeImmutable $dateBegin): static
    {
        $this->dateBegin = $dateBegin;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeImmutable
    {
        return $this->dateEnd;
    }

    public function setDateEnd(\DateTimeImmutable $dateEnd): static
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    public function getService(): ?Filter
    {
        return $this->service;
    }

    public function setService(?Filter $service): static
    {
        $this->service = $service;

        return $this;
    }

    public function getPlace(): ?Filter
    {
        return $this->place;
    }

    public function setPlace(?Filter $place): static
    {
        $this->place = $place;

        return $this;
    }


}
