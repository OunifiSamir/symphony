<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Matche
 *
 * @ORM\Table(name="matche", indexes={@ORM\Index(name="arbitre", columns={"arbitre"}), @ORM\Index(name="terrain", columns={"terrain"}), @ORM\Index(name="equipe1", columns={"equipe1"}), @ORM\Index(name="equipe2", columns={"equipe2"}), @ORM\Index(name="niveau_competition", columns={"niveau_competition"})})
 * @ORM\Entity
 */
class Matche
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
     * @var \DateTime
     *
     * @ORM\Column(name="date_creation", type="datetime", nullable=false)
     */
    private $dateCreation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_match", type="datetime", nullable=false)
     */
    private $dateMatch;

    /**
     * @var int|null
     *
     * @ORM\Column(name="resultat_eq1", type="integer", nullable=true)
     */
    private $resultatEq1;

    /**
     * @var int|null
     *
     * @ORM\Column(name="resultat_eq2", type="integer", nullable=true)
     */
    private $resultatEq2;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="valide", type="boolean", nullable=true)
     */
    private $valide;

    /**
     * @var int|null
     *
     * @ORM\Column(name="arbitre", type="integer", nullable=true)
     */
    private $arbitre;

    /**
     * @var \Equipe
     *
     * @ORM\ManyToOne(targetEntity="Equipe")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="equipe1", referencedColumnName="id")
     * })
     */
    private $equipe1;

    /**
     * @var \Equipe
     *
     * @ORM\ManyToOne(targetEntity="Equipe")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="equipe2", referencedColumnName="id")
     * })
     */
    private $equipe2;

    /**
     * @var \Terrain
     *
     * @ORM\ManyToOne(targetEntity="Terrain")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="terrain", referencedColumnName="id")
     * })
     */
    private $terrain;

    /**
     * @var \NiveauCompetition
     *
     * @ORM\ManyToOne(targetEntity="NiveauCompetition")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="niveau_competition", referencedColumnName="id")
     * })
     */
    private $niveauCompetition;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getDateMatch(): ?\DateTimeInterface
    {
        return $this->dateMatch;
    }

    public function setDateMatch(\DateTimeInterface $dateMatch): self
    {
        $this->dateMatch = $dateMatch;

        return $this;
    }

    public function getResultatEq1(): ?int
    {
        return $this->resultatEq1;
    }

    public function setResultatEq1(?int $resultatEq1): self
    {
        $this->resultatEq1 = $resultatEq1;

        return $this;
    }

    public function getResultatEq2(): ?int
    {
        return $this->resultatEq2;
    }

    public function setResultatEq2(?int $resultatEq2): self
    {
        $this->resultatEq2 = $resultatEq2;

        return $this;
    }

    public function getValide(): ?bool
    {
        return $this->valide;
    }

    public function setValide(?bool $valide): self
    {
        $this->valide = $valide;

        return $this;
    }

    public function getArbitre(): ?int
    {
        return $this->arbitre;
    }

    public function setArbitre(?int $arbitre): self
    {
        $this->arbitre = $arbitre;

        return $this;
    }

    public function getEquipe1(): ?Equipe
    {
        return $this->equipe1;
    }

    public function setEquipe1(?Equipe $equipe1): self
    {
        $this->equipe1 = $equipe1;

        return $this;
    }

    public function getEquipe2(): ?Equipe
    {
        return $this->equipe2;
    }

    public function setEquipe2(?Equipe $equipe2): self
    {
        $this->equipe2 = $equipe2;

        return $this;
    }

    public function getTerrain(): ?Terrain
    {
        return $this->terrain;
    }

    public function setTerrain(?Terrain $terrain): self
    {
        $this->terrain = $terrain;

        return $this;
    }

    public function getNiveauCompetition(): ?NiveauCompetition
    {
        return $this->niveauCompetition;
    }

    public function setNiveauCompetition(?NiveauCompetition $niveauCompetition): self
    {
        $this->niveauCompetition = $niveauCompetition;

        return $this;
    }


}
