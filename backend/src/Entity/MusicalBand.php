<?php

namespace App\Entity;

use App\Repository\MusicalBandRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MusicalBandRepository::class)]
class MusicalBand
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $origin = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $founded_at = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $separation_date = null;

    #[ORM\Column(length: 255)]
    private ?string $founders = null;

    #[ORM\Column]
    private ?int $members = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $music_style = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $about = null;

    /**
     * @var Collection<int, Concert>
     */
    #[ORM\ManyToMany(targetEntity: Concert::class, mappedBy: 'bands')]
    private Collection $concerts;

    public function __construct()
    {
        $this->concerts = new ArrayCollection();
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

    public function getOrigin(): ?string
    {
        return $this->origin;
    }

    public function setOrigin(string $origin): static
    {
        $this->origin = $origin;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getFoundedAt(): ?\DateTimeImmutable
    {
        return $this->founded_at;
    }

    public function setFoundedAt(\DateTimeImmutable $founded_at): static
    {
        $this->founded_at = $founded_at;

        return $this;
    }

    public function getSeparationDate(): ?\DateTimeInterface
    {
        return $this->separation_date;
    }

    public function setSeparationDate(?\DateTimeInterface $separation_date): static
    {
        $this->separation_date = $separation_date;

        return $this;
    }

    public function getFounders(): ?string
    {
        return $this->founders;
    }

    public function setFounders(string $founders): static
    {
        $this->founders = $founders;

        return $this;
    }

    public function getMembers(): ?int
    {
        return $this->members;
    }

    public function setMembers(int $members): static
    {
        $this->members = $members;

        return $this;
    }

    public function getMusicStyle(): ?string
    {
        return $this->music_style;
    }

    public function setMusicStyle(?string $music_style): static
    {
        $this->music_style = $music_style;

        return $this;
    }

    public function getAbout(): ?string
    {
        return $this->about;
    }

    public function setAbout(string $about): static
    {
        $this->about = $about;

        return $this;
    }

    /**
     * @return Collection<int, Concert>
     */
    public function getConcerts(): Collection
    {
        return $this->concerts;
    }

    public function addConcert(Concert $concert): static
    {
        if (!$this->concerts->contains($concert)) {
            $this->concerts->add($concert);
            $concert->addBand($this);
        }

        return $this;
    }

    public function removeConcert(Concert $concert): static
    {
        if ($this->concerts->removeElement($concert)) {
            $concert->removeBand($this);
        }

        return $this;
    }
}
