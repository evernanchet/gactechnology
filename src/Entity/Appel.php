<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Appel
 *
 * @ORM\Table(name="appel")
 * @ORM\Entity(repositoryClass="App\Repository\AppelRepository")
 */
class Appel
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
     * @var int
     *
     * @ORM\Column(name="compte_facture", type="integer", nullable=false)
     */
    private $compteFacture;

    /**
     * @var int
     *
     * @ORM\Column(name="num_facture", type="integer", nullable=false)
     */
    private $numFacture;

    /**
     * @var int
     *
     * @ORM\Column(name="num_abonne", type="integer", nullable=false)
     */
    private $numAbonne;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="heure", type="time", nullable=false)
     */
    private $heure;

    /**
     * @var string
     *
     * @ORM\Column(name="duree_volume_reel", type="string", length=255, nullable=false)
     */
    private $dureeVolumeReel;

    /**
     * @var string
     *
     * @ORM\Column(name="duree_volume_facture", type="string", length=255, nullable=false)
     */
    private $dureeVolumeFacture;

    /**
     * @var int
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=false)
     */
    private $type;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompteFacture(): ?int
    {
        return $this->compteFacture;
    }

    public function setCompteFacture(int $compteFacture): self
    {
        $this->compteFacture = $compteFacture;

        return $this;
    }

    public function getNumFacture(): ?int
    {
        return $this->numFacture;
    }

    public function setNumFacture(int $numFacture): self
    {
        $this->numFacture = $numFacture;

        return $this;
    }

    public function getNumAbonne(): ?int
    {
        return $this->numAbonne;
    }

    public function setNumAbonne(int $numAbonne): self
    {
        $this->numAbonne = $numAbonne;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getHeure(): ?\DateTimeInterface
    {
        return $this->heure;
    }

    public function setHeure(\DateTimeInterface $heure): self
    {
        $this->heure = $heure;

        return $this;
    }

    public function getDureeVolumeReel(): ?string
    {
        return $this->dureeVolumeReel;
    }

    public function setDureeVolumeReel(string $dureeVolumeReel): self
    {
        $this->dureeVolumeReel = $dureeVolumeReel;

        return $this;
    }

    public function getDureeVolumeFacture(): ?string
    {
        return $this->dureeVolumeFacture;
    }

    public function setDureeVolumeFacture(string $dureeVolumeFacture): self
    {
        $this->dureeVolumeFacture = $dureeVolumeFacture;

        return $this;
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


}
