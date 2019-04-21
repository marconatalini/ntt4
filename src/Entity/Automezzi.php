<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Automezzi
 *
 * @ORM\Table(name="automezzi")
 * @ORM\Entity
 */
class Automezzi
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
     * @ORM\Column(name="targa", type="string", length=7, nullable=false)
     */
    private $targa;

    /**
     * @var string
     *
     * @ORM\Column(name="modello", type="string", length=30, nullable=false)
     */
    private $modello;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="data_acquisto", type="datetime", nullable=true)
     */
    private $dataAcquisto;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="data_bollo", type="datetime", nullable=true)
     */
    private $dataBollo;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="data_revisione", type="datetime", nullable=true)
     */
    private $dataRevisione;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="dismesso", type="boolean", nullable=true)
     */
    private $dismesso = '0';

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
    private $lstupd;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTarga(): ?string
    {
        return $this->targa;
    }

    public function setTarga(string $targa): self
    {
        $this->targa = $targa;

        return $this;
    }

    public function getModello(): ?string
    {
        return $this->modello;
    }

    public function setModello(string $modello): self
    {
        $this->modello = $modello;

        return $this;
    }

    public function getDataAcquisto(): ?\DateTimeInterface
    {
        return $this->dataAcquisto;
    }

    public function setDataAcquisto(?\DateTimeInterface $dataAcquisto): self
    {
        $this->dataAcquisto = $dataAcquisto;

        return $this;
    }

    public function getDataBollo(): ?\DateTimeInterface
    {
        return $this->dataBollo;
    }

    public function setDataBollo(?\DateTimeInterface $dataBollo): self
    {
        $this->dataBollo = $dataBollo;

        return $this;
    }

    public function getDataRevisione(): ?\DateTimeInterface
    {
        return $this->dataRevisione;
    }

    public function setDataRevisione(?\DateTimeInterface $dataRevisione): self
    {
        $this->dataRevisione = $dataRevisione;

        return $this;
    }

    public function getDismesso(): ?bool
    {
        return $this->dismesso;
    }

    public function setDismesso(?bool $dismesso): self
    {
        $this->dismesso = $dismesso;

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
