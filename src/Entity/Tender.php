<?php

namespace App\Entity;

use App\Repository\TenderRepository;
use App\Trait\EntityDateStampTrait;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\SerializedName;

#[ORM\Entity(repositoryClass: TenderRepository::class)]
#[ORM\HasLifecycleCallbacks()]
class Tender
{
    use EntityDateStampTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $externalCode = null;

    #[ORM\Column(length: 255)]
    private ?string $number = null;

    #[ORM\ManyToOne(inversedBy: 'tenders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TenderStatus $status = null;

    #[ORM\Column(length: 500)]
    private ?string $name = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExternalCode(): ?string
    {
        return $this->externalCode;
    }

    public function setExternalCode(string $externalCode): static
    {
        $this->externalCode = $externalCode;

        return $this;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): static
    {
        $this->number = $number;

        return $this;
    }

    
    /**
     * Summary of getStatus
     * @return TenderStatus|null
     */
    public function getStatus(): ?TenderStatus
    {
        return $this->status;
    }

    public function setStatus(?TenderStatus $status): static
    {
        $this->status = $status;

        return $this;
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
}
