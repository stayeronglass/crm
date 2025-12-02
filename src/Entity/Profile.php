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


}
