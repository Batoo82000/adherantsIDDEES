<?php

namespace App\Entity;

use App\Repository\SiteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SiteRepository::class)]
class Site
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 85)]
    private ?string $nom = null;

    /**
     * @var Collection<int, Adherants>
     */
    #[ORM\OneToMany(targetEntity: Adherants::class, mappedBy: 'site')]
    private Collection $adherant;

    public function __construct()
    {
        $this->adherant = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->nom;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, Adherants>
     */
    public function getAdherant(): Collection
    {
        return $this->adherant;
    }

    public function addAdherant(Adherants $adherant): static
    {
        if (!$this->adherant->contains($adherant)) {
            $this->adherant->add($adherant);
            $adherant->setSite($this);
        }

        return $this;
    }

    public function removeAdherant(Adherants $adherant): static
    {
        if ($this->adherant->removeElement($adherant)) {
            // set the owning side to null (unless already changed)
            if ($adherant->getSite() === $this) {
                $adherant->setSite(null);
            }
        }

        return $this;
    }
}
