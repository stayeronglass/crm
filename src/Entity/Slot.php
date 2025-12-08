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

#[\Attribute]
#[ORM\Entity(repositoryClass: SlotRepository::class)]
#[ORM\Index(columns: ['date_begin','date_end'])]
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

    #[ORM\ManyToMany(targetEntity: Resource::class, inversedBy: 'slots')]
    private Collection $resource;

    #[ORM\ManyToMany(targetEntity: Service::class)]
    private Collection $service;


    #[ORM\Column(type: Types::FLOAT, nullable: false)]
    #[Assert\NotNull]
    #[Assert\NotBlank]
    #[Assert\Range(
        notInRangeMessage: 'Цена должна быть от {{ min }} до {{ max }}',
        min: 1,
        max: 1000000,
    )]
    private ?float $price;

    #[ORM\Column(type: Types::STRING, length: 7, nullable: false)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 7,max: 7,)]
    #[Assert\Regex('/^#[0-9a-f]{6}$/i')]
    private ?string $color;

    public function __construct()
    {
        $this->resource = new ArrayCollection();
        $this->service = new ArrayCollection();
    }

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

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): static
    {
        $this->color = $color;

        return $this;
    }

    /**
     * @return Collection<int, Resource>
     */
    public function getResource(): Collection
    {
        return $this->resource;
    }

    public function addResource(Resource $resource): static
    {
        if (!$this->resource->contains($resource)) {
            $this->resource->add($resource);
        }

        return $this;
    }

    public function removeResource(Resource $resource): static
    {
        $this->resource->removeElement($resource);

        return $this;
    }

    /**
     * @return Collection<int, Service>
     */
    public function getService(): Collection
    {
        return $this->service;
    }

    public function addService(Service $service): static
    {
        if (!$this->service->contains($service)) {
            $this->service->add($service);
        }

        return $this;
    }

    public function removeService(Service $service): static
    {
        $this->service->removeElement($service);

        return $this;
    }



}
