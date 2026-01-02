<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\SoftDeleteable\SoftDeleteable;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Timestampable;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator as AcmeAssert;

#[ORM\Entity(repositoryClass: EventRepository::class)]
#[ORM\Index(columns: ['date_begin','date_end'])]
#[AcmeAssert\EventPriority]
#[AcmeAssert\Slot]
class Event implements Timestampable, SoftDeleteable
{
    use TimestampableEntity, SoftDeleteableEntity;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 3,max: 100000,
        minMessage: 'Комментарий быть хотя бы {{ min }} символа',
        maxMessage: 'Комментарий не может быть больше {{ max }} символов',
    )]
    private ?string $comment;

    #[ORM\Column(type: 'datetimetz_immutable')]
    #[Assert\NotNull(message: 'Не выбрана дата начала!')]
    #[Assert\NotBlank(message: 'Не выбрана дата начала!')]
    #[Assert\Type(\DateTimeInterface::class)]
    #[Assert\GreaterThan('now', message: 'Дата начала не может быть в прошлом!')]
    #[Assert\LessThan('next year', message: 'Слишком большая дата начала!')]
    private \DateTimeImmutable $dateBegin;

    #[ORM\Column(type: 'datetimetz_immutable')]
    #[Assert\NotNull(message: 'Не выбрана дата окончания!')]
    #[Assert\NotBlank(message: 'Не выбрана дата окончания!')]
    #[Assert\Type(\DateTimeInterface::class)]
    #[Assert\GreaterThan(propertyPath: 'dateBegin', message: 'Дата окончания должна быть больше даты кончания!')]
    #[Assert\GreaterThan('now', message: 'Дата окончания не может быть в прошлом!')]
    #[Assert\LessThan('next year', message: 'Слишком большая дата окончания!')]
    private \DateTimeImmutable $dateEnd;

    #[ORM\ManyToOne(targetEntity: Resource::class)]
    #[Assert\NotNull(message: 'Не выбрано место!')]
    #[Assert\NotBlank(message: 'Не выбрано место!')]
    private ?Resource $resource;

    #[ORM\ManyToOne(targetEntity: Service::class)]
    #[Assert\NotNull(message: 'Не выбрана услуга!')]
    #[Assert\NotBlank(message: 'Не выбрана услуга!')]
    private ?Service $service;

    #[ORM\ManyToOne(targetEntity: Slot::class)]
    private ?Slot $slot;

    #[ORM\ManyToOne(targetEntity: Client::class, cascade: ['persist'])]
    #[Assert\NotNull(message: 'Нет клиента!')]
    #[Assert\NotBlank(message: 'Нет клиента!')]
    private ?Client $client;


    #[ORM\Column(type: Types::STRING, length: 7, nullable: false)]
    #[Assert\NotBlank(message: 'Пустой цвет!')]
    #[Assert\Length(min: 7,max: 7,)]
    #[Assert\Regex('/^#[0-9a-f]{6}$/i', message: 'Неверный формат цвета!')]
    private ?string $color;



    #[ORM\Column(type: Types::BIGINT, nullable: true)]
    #[Assert\NotNull(message: 'Пустое количество клиентов!')]
    #[Assert\NotBlank(message: 'Пустое количество клиентов!')]
    #[Assert\GreaterThan(0, message: 'Количество клиентов должно быть больше нуля!')]
    #[Assert\LessThan(100, message: 'Количество клиентов должно быть меньше 100!')]
    private ?int $clientsNumber;

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

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): static
    {
        $this->color = $color;

        return $this;
    }

    public function getClientsNumber(): ?string
    {
        return $this->clientsNumber;
    }

    public function setClientsNumber(?string $clientsNumber): static
    {
        $this->clientsNumber = $clientsNumber;

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

    public function getSlot(): ?Slot
    {
        return $this->slot;
    }

    public function setSlot(?Slot $slot): static
    {
        $this->slot = $slot;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): static
    {
        $this->client = $client;

        return $this;
    }



}
