<?php
declare(strict_types=1);
namespace App\Entity;

use App\Repository\ProfileRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\SoftDeleteable\SoftDeleteable;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Timestampable;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProfileRepository::class)]
class Profile implements Timestampable, SoftDeleteable
{
    use TimestampableEntity, SoftDeleteableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING,  length: 255, nullable: false)]
    #[Assert\NotNull]
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max:255)]
    private string $firstName;

    #[ORM\Column(type: Types::STRING,  length: 255, nullable: false)]
    #[Assert\NotNull]
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max:255)]
    private string $lastName;

    #[ORM\Column(type: Types::STRING,  length: 255, nullable: true)]
    #[Assert\NotNull]
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max:255)]
    private string $middleName;

    #[ORM\Column(type: Types::STRING,  length: 255, nullable: true)]
    #[Assert\NotNull]
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max:255)]
    private string $phone;

    #[ORM\OneToOne(inversedBy: 'profile', targetEntity: User::class, cascade: ['persist'])]
    private ?User $user = null;


    #[ORM\Column(type: Types::STRING,  length: 2, nullable: true)]
    #[Assert\NotNull]
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max:2)]
    private string $locale;

    #[ORM\Column(type: Types::STRING,  length: 3, nullable: true)]
    #[Assert\NotNull]
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max:3)]
    private string $currency;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getMiddleName(): ?string
    {
        return $this->middleName;
    }

    public function setMiddleName(?string $middleName): static
    {
        $this->middleName = $middleName;

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

    public function getLocale(): ?string
    {
        return $this->locale;
    }

    public function setLocale(?string $locale): static
    {
        $this->locale = $locale;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(?string $currency): static
    {
        $this->currency = $currency;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }


}
