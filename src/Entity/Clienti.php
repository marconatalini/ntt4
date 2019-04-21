<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Clienti
 *
 * @ORM\Table(name="clienti", indexes={@ORM\Index(name="pagamento_id_clienti_pagamenti_idx", columns={"pagamento_id"})})
 * @ORM\Entity
 */
class Clienti
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
     * @ORM\Column(name="codice", type="string", length=12, nullable=false)
     */
    private $codice;

    /**
     * @var string
     *
     * @ORM\Column(name="ragione_sociale", type="string", length=50, nullable=false)
     */
    private $ragioneSociale;

    /**
     * @var string
     *
     * @ORM\Column(name="p_iva", type="string", length=11, nullable=false)
     */
    private $pIva;

    /**
     * @var string|null
     *
     * @ORM\Column(name="indirizzo", type="string", length=40, nullable=true)
     */
    private $indirizzo;

    /**
     * @var string|null
     *
     * @ORM\Column(name="cap", type="string", length=5, nullable=true)
     */
    private $cap;

    /**
     * @var string|null
     *
     * @ORM\Column(name="paese", type="string", length=30, nullable=true)
     */
    private $paese;

    /**
     * @var string|null
     *
     * @ORM\Column(name="note", type="string", length=255, nullable=true)
     */
    private $note;

    /**
     * @var string|null
     *
     * @ORM\Column(name="um", type="string", length=10, nullable=true)
     */
    private $um;

    /**
     * @var \Province
     *
     * @ORM\ManyToOne(targetEntity="Province")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="provincia_id", referencedColumnName="id")
     * })
     */
    private $provincia;

    /**
     * @var string|null
     *
     * @ORM\Column(name="telefono", type="string", length=20, nullable=true)
     */
    private $telefono;

    /**
     * @var string|null
     *
     * @ORM\Column(name="fax", type="string", length=20, nullable=true)
     */
    private $fax;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo", type="string", length=1, nullable=false, options={"default"="C"})
     */
    private $tipo = 'C';

    /**
     * @var string|null
     *
     * @ORM\Column(name="email", type="string", length=150, nullable=true)
     */
    private $email;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nota_fattura", type="string", length=255, nullable=true)
     */
    private $notaFattura;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="esente_iva", type="boolean", nullable=true)
     */
    private $esenteIva;

    /**
     * @var string|null
     *
     * @ORM\Column(name="spesaIncasso", type="decimal", precision=6, scale=2, nullable=true, options={"default"="0.00"})
     */
    private $spesaincasso = '0.00';

    /**
     * @var string|null
     *
     * @ORM\Column(name="utente", type="string", length=45, nullable=true)
     */
    private $utente;

    /**
     * @var string|null
     *
     * @ORM\Column(name="pec", type="string", length=150, nullable=true)
     */
    private $pec;

    /**
     * @var string
     *
     * @ORM\Column(name="sdi", type="string", length=7, nullable=false, options={"default"="0000000"})
     */
    private $sdi = '0000000';

    /**
     * @var \ModoPagamento
     *
     * @ORM\ManyToOne(targetEntity="ModoPagamento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="pagamento_id", referencedColumnName="id")
     * })
     */
    private $pagamento;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodice(): ?string
    {
        return $this->codice;
    }

    public function setCodice(string $codice): self
    {
        $this->codice = $codice;

        return $this;
    }

    public function getRagioneSociale(): ?string
    {
        return $this->ragioneSociale;
    }

    public function setRagioneSociale(string $ragioneSociale): self
    {
        $this->ragioneSociale = $ragioneSociale;

        return $this;
    }

    public function getPIva(): ?string
    {
        return $this->pIva;
    }

    public function setPIva(string $pIva): self
    {
        $this->pIva = $pIva;

        return $this;
    }

    public function getIndirizzo(): ?string
    {
        return $this->indirizzo;
    }

    public function setIndirizzo(?string $indirizzo): self
    {
        $this->indirizzo = $indirizzo;

        return $this;
    }

    public function getCap(): ?string
    {
        return $this->cap;
    }

    public function setCap(?string $cap): self
    {
        $this->cap = $cap;

        return $this;
    }

    public function getPaese(): ?string
    {
        return $this->paese;
    }

    public function setPaese(?string $paese): self
    {
        $this->paese = $paese;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getUm(): ?string
    {
        return $this->um;
    }

    public function setUm(?string $um): self
    {
        $this->um = $um;

        return $this;
    }

    public function getProvincia(): ?Province
    {
        return $this->provincia;
    }

    public function setProvincia(?Province $provincia): self
    {
        $this->provincia = $provincia;

        return $this;
    }

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(?string $telefono): self
    {
        $this->telefono = $telefono;

        return $this;
    }

    public function getFax(): ?string
    {
        return $this->fax;
    }

    public function setFax(?string $fax): self
    {
        $this->fax = $fax;

        return $this;
    }

    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function setTipo(string $tipo): self
    {
        $this->tipo = $tipo;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getNotaFattura(): ?string
    {
        return $this->notaFattura;
    }

    public function setNotaFattura(?string $notaFattura): self
    {
        $this->notaFattura = $notaFattura;

        return $this;
    }

    public function getEsenteIva(): ?bool
    {
        return $this->esenteIva;
    }

    public function setEsenteIva(?bool $esenteIva): self
    {
        $this->esenteIva = $esenteIva;

        return $this;
    }

    public function getSpesaincasso()
    {
        return $this->spesaincasso;
    }

    public function setSpesaincasso($spesaincasso): self
    {
        $this->spesaincasso = $spesaincasso;

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

    public function getPec(): ?string
    {
        return $this->pec;
    }

    public function setPec(?string $pec): self
    {
        $this->pec = $pec;

        return $this;
    }

    public function getSdi(): ?string
    {
        return $this->sdi;
    }

    public function setSdi(string $sdi): self
    {
        $this->sdi = $sdi;

        return $this;
    }

    public function getPagamento(): ?ModoPagamento
    {
        return $this->pagamento;
    }

    public function setPagamento(?ModoPagamento $pagamento): self
    {
        $this->pagamento = $pagamento;

        return $this;
    }

}
