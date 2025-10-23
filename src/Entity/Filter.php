<?php

namespace App\Entity;

use App\Repository\FilterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\SoftDeleteable\SoftDeleteable;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Timestampable;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: FilterRepository::class)]
#[Gedmo\Tree(type: 'nested')]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false)]
class Filter implements Timestampable, SoftDeleteable
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
    private ?\DateTimeImmutable $dateBegin;

    #[ORM\Column(type: 'datetimetz_immutable')]
    #[Assert\NotNull]
    private ?\DateTimeImmutable $dateEnd;

    #[Gedmo\TreeLeft]
    #[ORM\Column(name: 'lft', type: Types::INTEGER)]
    private ?int $lft;


    #[Gedmo\TreeLevel]
    #[ORM\Column(name: 'lvl', type: Types::INTEGER)]
    private ?int $lvl;


    #[Gedmo\TreeRight]
    #[ORM\Column(name: 'rgt', type: Types::INTEGER)]
    private ?int $rgt;


    #[Gedmo\TreeRoot]
    #[ORM\ManyToOne(targetEntity: Filter::class)]
    #[ORM\JoinColumn(name: 'tree_root', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private ?Filter $root;


    #[Gedmo\TreeParent]
    #[ORM\ManyToOne(targetEntity: Filter::class, inversedBy: 'children')]
    #[ORM\JoinColumn(name: 'parent_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private ?Filter $parent;


    #[ORM\OneToMany(targetEntity: Filter::class, mappedBy: 'parent')]
    #[ORM\OrderBy(['lft' => 'ASC'])]
    private Collection $children;

    #[ORM\ManyToMany(targetEntity: Slot::class, inversedBy: 'filters', cascade: ['persist'])]
    private Collection $slots;

    public function __construct()
    {
        $this->children = new ArrayCollection();
        $this->slots = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLft(): ?int
    {
        return $this->lft;
    }

    public function setLft(int $lft): static
    {
        $this->lft = $lft;

        return $this;
    }

    public function getLvl(): ?int
    {
        return $this->lvl;
    }

    public function setLvl(int $lvl): static
    {
        $this->lvl = $lvl;

        return $this;
    }

    public function getRgt(): ?int
    {
        return $this->rgt;
    }

    public function setRgt(int $rgt): static
    {
        $this->rgt = $rgt;

        return $this;
    }

    public function getRoot(): ?self
    {
        return $this->root;
    }

    public function setRoot(?self $root): static
    {
        $this->root = $root;

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): static
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection<int, Filter>
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addChild(Filter $child): static
    {
        if (!$this->children->contains($child)) {
            $this->children->add($child);
            $child->setParent($this);
        }

        return $this;
    }

    public function removeChild(Filter $child): static
    {
        if ($this->children->removeElement($child)) {
            // set the owning side to null (unless already changed)
            if ($child->getParent() === $this) {
                $child->setParent(null);
            }
        }

        return $this;
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

    /**
     * @return Collection<int, Slot>
     */
    public function getSlots(): Collection
    {
        return $this->slots;
    }

    public function addSlot(Slot $slot): static
    {
        if (!$this->slots->contains($slot)) {
            $this->slots->add($slot);
        }

        return $this;
    }

    public function removeSlot(Slot $slot): static
    {
        $this->slots->removeElement($slot);

        return $this;
    }


    public function __toString(): string
    {
        return $this->getTitle() ?? '';
    }
}
