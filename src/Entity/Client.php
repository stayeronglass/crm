<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Index(columns: ['phone'])]
#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    #[Assert\NotNull(message: 'Пустое имя клиента!')]
    #[Assert\NotBlank(message: 'Пустое имя клиента!')]
    #[Assert\Length(
        min: 3,
        max: 255,
        minMessage: 'Имя клиента должно быть хотя бы {{ min }} символа',
        maxMessage: 'Имя клиента не может быть больше {{ max }} символов',
    )]
    private ?string $name;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    #[Assert\NotBlank(message: 'Пустой email клиента!')]
    #[Assert\Length(min: 3,max: 255,
        minMessage: 'Email должен быть хотя бы {{ min }} символа',
        maxMessage: 'Email не может быть больше {{ max }} символов',
    )]
    #[Assert\Email(message: 'Неверный формат email!')]
    private ?string $email;

    #[ORM\Column(type: Types::STRING, length: 11, nullable: true)]
    #[Assert\NotNull(message: 'Пустой телефон клиента!')]
    #[Assert\NotBlank(message: 'Пустой телефон клиента!')]
    #[Assert\Length(min: 11,max: 11,  minMessage: 'Слишком короткий телефон (должен быть ровно 11 цифр)!', maxMessage: 'Слишком длинный телефон (должен быть ровно 10 цифр)!',)]
    #[Assert\Regex('/^[0-9]{11}$/i', message: 'Неверный формат телефона (должен быть ровно 11 цифр)!')]
    private ?string $phone;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    #[Assert\Length(min: 3,max: 255,
        minMessage: 'Телеграм должен быть хотя бы {{ min }} символа',
        maxMessage: 'Телеграм не может быть больше {{ max }} символов',
    )]
    private ?string $telegram;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getTelegram(): ?string
    {
        return $this->telegram;
    }

    public function setTelegram(?string $telegram): static
    {
        $this->telegram = $telegram;

        return $this;
    }

}
