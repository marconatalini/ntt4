<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Province
 *
 * @ORM\Table(name="province")
 * @ORM\Entity
 */
class Province
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
     * @ORM\Column(name="sigla", type="string", length=2, nullable=false)
     */
    private $sigla;

    /**
     * @var string
     *
     * @ORM\Column(name="provincia", type="string", length=20, nullable=false)
     */
    private $provincia;

    /**
     * @var int
     *
     * @ORM\Column(name="regione_id", type="integer", nullable=false)
     */
    private $regioneId = '0';

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

    public function getSigla(): ?string
    {
        return $this->sigla;
    }

    public function setSigla(string $sigla): self
    {
        $this->sigla = $sigla;

        return $this;
    }

    public function getProvincia(): ?string
    {
        return $this->provincia;
    }

    public function setProvincia(string $provincia): self
    {
        $this->provincia = $provincia;

        return $this;
    }

    public function getRegioneId(): ?int
    {
        return $this->regioneId;
    }

    public function setRegioneId(int $regioneId): self
    {
        $this->regioneId = $regioneId;

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
