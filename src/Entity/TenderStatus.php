<?php

namespace App\Entity;

use App\Repository\TenderStatusRepository;
use App\Trait\EntityDateStampTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TenderStatusRepository::class)]
#[ORM\HasLifecycleCallbacks()]
class TenderStatus
{
    use EntityDateStampTrait;
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $name = null;

    /**
     * @var Collection<int, Tender>
     */
    #[ORM\OneToMany(targetEntity: Tender::class, mappedBy: 'status')]
    private Collection $tenders;

    public function __construct()
    {
        $this->tenders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Tender>
     */
    public function getTenders(): Collection
    {
        return $this->tenders;
    }

    public function addTender(Tender $tender): static
    {
        if (!$this->tenders->contains($tender)) {
            $this->tenders->add($tender);
            $tender->setStatus($this);
        }

        return $this;
    }

    public function removeTender(Tender $tender): static
    {
        if ($this->tenders->removeElement($tender)) {
            // set the owning side to null (unless already changed)
            if ($tender->getStatus() === $this) {
                $tender->setStatus(null);
            }
        }

        return $this;
    }
}
