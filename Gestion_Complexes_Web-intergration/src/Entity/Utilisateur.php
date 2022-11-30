<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Utilisateur
 *
 * @ORM\Table(name="utilisateur", indexes={@ORM\Index(name="equipe", columns={"equipe"})})
 * @ORM\Entity
 */
class Utilisateur
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
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=100, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=32, nullable=false)
     */
    private $password;

    /**
     * @var string|null
     *
     * @ORM\Column(name="role", type="string", length=30, nullable=true)
     */
    private $role;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nom", type="string", length=30, nullable=true)
     */
    private $nom;

    /**
     * @var string|null
     *
     * @ORM\Column(name="prenom", type="string", length=20, nullable=true)
     */
    private $prenom;

    /**
     * @var int|null
     *
     * @ORM\Column(name="categorie", type="integer", nullable=true)
     */
    private $categorie;

    /**
     * @var string|null
     *
     * @ORM\Column(name="raison_sociale", type="string", length=20, nullable=true)
     */
    private $raisonSociale;

    /**
     * @var string|null
     *
     * @ORM\Column(name="matricule_fiscale", type="string", length=20, nullable=true)
     */
    private $matriculeFiscale;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="verifie", type="boolean", nullable=true)
     */
    private $verifie;

    /**
     * @var int|null
     *
     * @ORM\Column(name="solde_point", type="integer", nullable=true)
     */
    private $soldePoint;

    /**
     * @var string|null
     *
     * @ORM\Column(name="position", type="string", length=20, nullable=true)
     */
    private $position;

    /**
     * @var string|null
     *
     * @ORM\Column(name="telephone", type="string", length=8, nullable=true)
     */
    private $telephone;

    /**
     * @var int
     *
     * @ORM\Column(name="position_equipe", type="integer", nullable=false)
     */
    private $positionEquipe;

    /**
     * @var \Equipe
     *
     * @ORM\ManyToOne(targetEntity="Equipe")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="equipe", referencedColumnName="id")
     * })
     */
    private $equipe;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(?string $role): self
    {
        $this->role = $role;

        return $this;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getCategorie(): ?int
    {
        return $this->categorie;
    }

    public function setCategorie(?int $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getRaisonSociale(): ?string
    {
        return $this->raisonSociale;
    }

    public function setRaisonSociale(?string $raisonSociale): self
    {
        $this->raisonSociale = $raisonSociale;

        return $this;
    }

    public function getMatriculeFiscale(): ?string
    {
        return $this->matriculeFiscale;
    }

    public function setMatriculeFiscale(?string $matriculeFiscale): self
    {
        $this->matriculeFiscale = $matriculeFiscale;

        return $this;
    }

    public function getVerifie(): ?bool
    {
        return $this->verifie;
    }

    public function setVerifie(?bool $verifie): self
    {
        $this->verifie = $verifie;

        return $this;
    }

    public function getSoldePoint(): ?int
    {
        return $this->soldePoint;
    }

    public function setSoldePoint(?int $soldePoint): self
    {
        $this->soldePoint = $soldePoint;

        return $this;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(?string $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getPositionEquipe(): ?int
    {
        return $this->positionEquipe;
    }

    public function setPositionEquipe(int $positionEquipe): self
    {
        $this->positionEquipe = $positionEquipe;

        return $this;
    }

    public function getEquipe(): ?Equipe
    {
        return $this->equipe;
    }

    public function setEquipe(?Equipe $equipe): self
    {
        $this->equipe = $equipe;

        return $this;
    }


}