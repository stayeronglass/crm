<?php

namespace App\Entity;

use App\Repository\SlotRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\SoftDeleteable\SoftDeleteable;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Timestampable;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SlotRepository::class)]
class Slot implements Timestampable, SoftDeleteable
{
    use TimestampableEntity, SoftDeleteableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[ORM\Column(length: 255, nullable: false)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 3,max: 255,)]
    private string $title;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\NotBlank]
    private ?string $description;

    #[ORM\Column(type: 'datetimetz_immutable')]
    #[Assert\NotNull]
    private \DateTimeImmutable $dateBegin;

    #[ORM\Column(type: 'datetimetz_immutable')]
    #[Assert\NotNull]
    private \DateTimeImmutable $dateEnd;

    #[ORM\ManyToOne(targetEntity: Resource::class, inversedBy: 'slots')]
    private ?Resource $resource;

    #[ORM\ManyToOne(targetEntity: Service::class)]
    private ?Service $service;


    #[ORM\Column(type: Types::FLOAT, nullable: false)]
    #[Assert\NotNull]
    #[Assert\NotNull]
    #[Assert\Range(
        notInRangeMessage: 'Цена должна быть от {{ min }} до {{ max }}',
        min: 1,
        max: 1000000,
    )]
    private ?float $price;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

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

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getResource(): ?Resource
    {
        return $this->resource;
    }

    public function setResource(?Resource $resource): static
    {
        $this->resource = $resource;

        return $this;
    }

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function setService(?Service $service): static
    {
        $this->service = $service;

        return $this;
    }


    public function __toString():string
    {
        return $this->title;
    }

}
