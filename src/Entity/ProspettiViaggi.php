<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProspettiViaggi
 *
 * @ORM\Table(name="prospetti_viaggi")
 * @ORM\Entity
 */
class ProspettiViaggi
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
     * @ORM\Column(name="numero", type="integer", nullable=false)
     */
    private $numero = '0';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data", type="datetime", nullable=false)
     */
    private $data;

    /**
     * @var int
     *
     * @ORM\Column(name="automezzo_id", type="integer", nullable=false)
     */
    private $automezzoId = '0';

    /**
     * @var bool|null
     *
     * @ORM\Column(name="stampato", type="boolean", nullable=true)
     */
    private $stampato;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function setNumero(int $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getData(): ?\DateTimeInterface
    {
        return $this->data;
    }

    public function setData(\DateTimeInterface $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function getAutomezzoId(): ?int
    {
        return $this->automezzoId;
    }

    public function setAutomezzoId(int $automezzoId): self
    {
        $this->automezzoId = $automezzoId;

        return $this;
    }

    public function getStampato(): ?bool
    {
        return $this->stampato;
    }

    public function setStampato(?bool $stampato): self
    {
        $this->stampato = $stampato;

        return $this;
    }


}
