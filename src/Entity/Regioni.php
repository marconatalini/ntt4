<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Regioni
 *
 * @ORM\Table(name="regioni")
 * @ORM\Entity
 */
class Regioni
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
     * @ORM\Column(name="regione", type="string", length=50, nullable=true)
     */
    private $regione;

    /**
     * @var int
     *
     * @ORM\Column(name="detrazione_id", type="integer", nullable=false)
     */
    private $detrazioneId = '0';

    /**
     * @var string|null
     *
     * @ORM\Column(name="utente", type="string", length=45, nullable=true)
     */
    private $utente;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="lstupd", type="datetime", nullable=true, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $lstupd = 'CURRENT_TIMESTAMP';

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRegione(): ?string
    {
        return $this->regione;
    }

    public function setRegione(?string $regione): self
    {
        $this->regione = $regione;

        return $this;
    }

    public function getDetrazioneId(): ?int
    {
        return $this->detrazioneId;
    }

    public function setDetrazioneId(int $detrazioneId): self
    {
        $this->detrazioneId = $detrazioneId;

        return $this;
    }

    public function getUtente(): ?string
    {
        return $this->utente;
    }

    public function setUtente(?string $utente): self
    {
        $this->utente = $utente;

        return $this;
    }

    public function getLstupd(): ?\DateTimeInterface
    {
        return $this->lstupd;
    }

    public function setLstupd(?\DateTimeInterface $lstupd): self
    {
        $this->lstupd = $lstupd;

        return $this;
    }


}
