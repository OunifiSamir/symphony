<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Equipe
 *
 * @ORM\Table(name="equipe", indexes={@ORM\Index(name="capitain", columns={"capitain"})})
 * @ORM\Entity
 */
class Equipe
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nom", type="string", length=100, nullable=true)
     */
    private $nom;

    /**
     * @var int
     *
     * @ORM\Column(name="nbre_joueur", type="integer", nullable=false)
     */
    private $nbreJoueur;

    /**
     * @var string
     *
     * @ORM\Column(name="logo", type="string", length=100, nullable=false)
     */
    private $logo;

    /**
     * @var \Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="capitain", referencedColumnName="id")
     * })
     */
    private $capitain;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getNbreJoueur(): ?int
    {
        return $this->nbreJoueur;
    }

    public function setNbreJoueur(int $nbreJoueur): self
    {
        $this->nbreJoueur = $nbreJoueur;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function getCapitain(): ?Utilisateur
    {
        return $this->capitain;
    }

    public function setCapitain(?Utilisateur $capitain): self
    {
        $this->capitain = $capitain;

        return $this;
    }


}
