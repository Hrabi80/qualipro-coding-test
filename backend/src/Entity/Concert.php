<?php

namespace App\Entity;

use App\Repository\ConcertRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConcertRepository::class)]
class Concert
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToOne(inversedBy: 'concerts')]
    private ?PartyHall $partyHall = null;

    /**
     * @var Collection<int, MusicalBand>
     */
    #[ORM\ManyToMany(targetEntity: MusicalBand::class, inversedBy: 'concerts')]
    private Collection $bands;

    public function __construct()
    {
        $this->bands = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getPartyHall(): ?PartyHall
    {
        return $this->partyHall;
    }

    public function setPartyHall(?PartyHall $partyHall): static
    {
        $this->partyHall = $partyHall;

        return $this;
    }

    /**
     * @return Collection<int, MusicalBand>
     */
    public function getBands(): Collection
    {
        return $this->bands;
    }

    public function addBand(MusicalBand $band): static
    {
        if (!$this->bands->contains($band)) {
            $this->bands->add($band);
        }

        return $this;
    }

    public function removeBand(MusicalBand $band): static
    {
        $this->bands->removeElement($band);

        return $this;
    }
}
