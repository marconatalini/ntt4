<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Detrazioni
 *
 * @ORM\Table(name="detrazioni")
 * @ORM\Entity
 */
class Detrazioni
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_Detrazione", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idDetrazione;

    /**
     * @var int|null
     *
     * @ORM\Column(name="Zona", type="integer", nullable=true)
     */
    private $zona = '0';

    /**
     * @var float
     *
     * @ORM\Column(name="Detrazione", type="float", precision=10, scale=0, nullable=false)
     */
    private $detrazione = '0';

    public function getIdDetrazione(): ?int
    {
        return $this->idDetrazione;
    }

    public function getZona(): ?int
    {
        return $this->zona;
    }

    public function setZona(?int $zona): self
    {
        $this->zona = $zona;

        return $this;
    }

    public function getDetrazione(): ?float
    {
        return $this->detrazione;
    }

    public function setDetrazione(float $detrazione): self
    {
        $this->detrazione = $detrazione;

        return $this;
    }


}
