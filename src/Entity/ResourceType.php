<?php

namespace App\Entity;

use App\Repository\ResourceTypeRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\SoftDeleteable\SoftDeleteable;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Timestampable;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
#[ORM\Entity(repositoryClass: ResourceTypeRepository::class)]
class ResourceType  implements Timestampable, SoftDeleteable
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


    #[ORM\OneToMany(targetEntity: Filter::class, mappedBy: 'resourceType', cascade: ['persist'])]
    private  Collection $filters;

    public function __construct()
    {
        $this->filters = new ArrayCollection();
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

    /**
     * @return Collection<int, Filter>
     */
    public function getFilters(): Collection
    {
        return $this->filters;
    }

    public function addFilter(Filter $filter): static
    {
        if (!$this->filters->contains($filter)) {
            $this->filters->add($filter);
            $filter->setResourceType($this);
        }

        return $this;
    }

    public function removeFilter(Filter $filter): static
    {
        if ($this->filters->removeElement($filter)) {
            // set the owning side to null (unless already changed)
            if ($filter->getResourceType() === $this) {
                $filter->setResourceType(null);
            }
        }

        return $this;
    }

}
