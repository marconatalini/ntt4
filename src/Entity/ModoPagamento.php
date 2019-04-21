<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ModoPagamento
 *
 * @ORM\Table(name="modo_pagamento", uniqueConstraints={@ORM\UniqueConstraint(name="Pagamento", columns={"pagamento"})})
 * @ORM\Entity
 */
class ModoPagamento
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
     * @ORM\Column(name="pagamento", type="string", length=50, nullable=false)
     */
    private $pagamento;

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

    public function getPagamento(): ?string
    {
        return $this->pagamento;
    }

    public function setPagamento(string $pagamento): self
    {
        $this->pagamento = $pagamento;

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
