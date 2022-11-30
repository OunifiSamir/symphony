<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Invitation
 *
 * @ORM\Table(name="invitation", indexes={@ORM\Index(name="equipe", columns={"equipe"}), @ORM\Index(name="utilisateur", columns={"utilisateur"})})
 * @ORM\Entity
 */
class Invitation
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
     * @ORM\Column(name="type", type="string", length=200, nullable=false)
     */
    private $type;

    /**
     * @var int
     *
     * @ORM\Column(name="equipe", type="integer", nullable=false)
     */
    private $equipe;

    /**
     * @var int
     *
     * @ORM\Column(name="valide", type="integer", nullable=false)
     */
    private $valide;

    /**
     * @var \Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="utilisateur", referencedColumnName="id")
     * })
     */
    private $utilisateur;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getEquipe(): ?int
    {
        return $this->equipe;
    }

    public function setEquipe(int $equipe): self
    {
        $this->equipe = $equipe;

        return $this;
    }

    public function getValide(): ?int
    {
        return $this->valide;
    }

    public function setValide(int $valide): self
    {
        $this->valide = $valide;

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }


}
