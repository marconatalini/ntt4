<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DatiGenerali
 *
 * @ORM\Table(name="dati_generali")
 * @ORM\Entity
 */
class DatiGenerali
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_datigenerali", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idDatigenerali;

    /**
     * @var string|null
     *
     * @ORM\Column(name="descrizione", type="string", length=50, nullable=true)
     */
    private $descrizione;

    /**
     * @var float|null
     *
     * @ORM\Column(name="valsng", type="float", precision=10, scale=0, nullable=true)
     */
    private $valsng = '0';

    /**
     * @var string|null
     *
     * @ORM\Column(name="valstr", type="string", length=50, nullable=true)
     */
    private $valstr;

    public function getIdDatigenerali(): ?int
    {
        return $this->idDatigenerali;
    }

    public function getDescrizione(): ?string
    {
        return $this->descrizione;
    }

    public function setDescrizione(?string $descrizione): self
    {
        $this->descrizione = $descrizione;

        return $this;
    }

    public function getValsng(): ?float
    {
        return $this->valsng;
    }

    public function setValsng(?float $valsng): self
    {
        $this->valsng = $valsng;

        return $this;
    }

    public function getValstr(): ?string
    {
        return $this->valstr;
    }

    public function setValstr(?string $valstr): self
    {
        $this->valstr = $valstr;

        return $this;
    }


}
