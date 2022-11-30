<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Reservation
 *
 * @ORM\Table(name="reservation", indexes={@ORM\Index(name="client", columns={"client"}), @ORM\Index(name="terrain", columns={"terrain"})})
 * @ORM\Entity(repositoryClass="App\Repository\ReservationRepository")
 */
class Reservation
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
     * @ORM\Column(name="date_creation", type="datetime", nullable=true, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $dateCreation = 'CURRENT_TIMESTAMP';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_reservation", type="datetime", nullable=true)

     */
    private $dateReservation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="heure", type="time", nullable=false)
     */
    private $heure;

    /**
     * @var bool
     *
     * @ORM\Column(name="validee", type="boolean", nullable=false)
     */
    private $validee = '0';

    /**
     * @var float
     *
     * @ORM\Column(name="montant", type="float", precision=10, scale=3, nullable=false)
     */
    private $montant;

    /**
     * @var bool
     *
     * @ORM\Column(name="acceptee", type="boolean", nullable=false)
     */
    private $acceptee;

    /**
     * @var \Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="client", referencedColumnName="id")
     * })
     */
    private $client;

    /**
     * @var \Terrain
     *
     * @ORM\ManyToOne(targetEntity="Terrain")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="terrain", referencedColumnName="id")
     * })
     */
    private $terrain;

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

    public function getDateReservation(): ?\DateTimeInterface
    {
        return $this->dateReservation;
    }

    public function setDateReservation(\DateTimeInterface $dateReservation): self
    {
        $this->dateReservation = $dateReservation;

        return $this;
    }

    public function getHeure(): ?\DateTimeInterface
    {
        return $this->heure;
    }

    public function setHeure($heure)
    {
        $this->heure = $heure;

        return $this;
    }

    public function getValidee(): ?bool
    {
        return $this->validee;
    }

    public function setValidee(bool $validee): self
    {
        $this->validee = $validee;

        return $this;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getAcceptee(): ?bool
    {
        return $this->acceptee;
    }

    public function setAcceptee(bool $acceptee): self
    {
        $this->acceptee = $acceptee;

        return $this;
    }

    public function getClient(): ?Utilisateur
    {
        return $this->client;
    }

    public function setClient(?Utilisateur $client): self
    {
        $this->client = $client;

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


}
