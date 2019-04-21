<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ddts
 *
 * @ORM\Table(name="ddts", indexes={@ORM\Index(name="id_cliente_ddts_clienti", columns={"cliente_id"}), @ORM\Index(name="id_prospetto_ddts_prospetti_idx", columns={"prospetto_id"}), @ORM\Index(name="id_fattura_ddts_fatture_idx", columns={"fattura_id"}), @ORM\Index(name="id_automezzo_ddts_automezzi_idx", columns={"automezzo_id"})})
 * @ORM\Entity
 */
class Ddts
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
     * @ORM\Column(name="data_ddt", type="datetime", nullable=false)
     */
    private $dataDdt;

    /**
     * @var string|null
     *
     * @ORM\Column(name="descrizione", type="string", length=55, nullable=true)
     */
    private $descrizione;

    /**
     * @var string|null
     *
     * @ORM\Column(name="numero_ddt", type="string", length=8, nullable=true)
     */
    private $numeroDdt;

    /**
     * @var int|null
     *
     * @ORM\Column(name="quantita", type="integer", nullable=true, options={"default"="1"})
     */
    private $quantita = '1';

    /**
     * @var string|null
     *
     * @ORM\Column(name="prezzo", type="decimal", precision=6, scale=2, nullable=true)
     */
    private $prezzo;

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
     * @var int|null
     *
     * @ORM\Column(name="peso", type="integer", nullable=true)
     */
    private $peso;

    /**
     * @var string|null
     *
     * @ORM\Column(name="utente", type="string", length=45, nullable=true)
     */
    private $utente;

    /**
     * @var \Automezzi
     *
     * @ORM\ManyToOne(targetEntity="Automezzi")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="automezzo_id", referencedColumnName="id")
     * })
     */
    private $automezzo;

    /**
     * @var \Clienti
     *
     * @ORM\ManyToOne(targetEntity="Clienti")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cliente_id", referencedColumnName="id")
     * })
     */
    private $cliente;

    /**
     * @var \Fatture
     *
     * @ORM\ManyToOne(targetEntity="Fatture", inversedBy="ddts")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fattura_id", referencedColumnName="id")
     * })
     */
    private $fattura;

    /**
     * @var \ProspettiViaggi
     *
     * @ORM\ManyToOne(targetEntity="ProspettiViaggi")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="prospetto_id", referencedColumnName="id")
     * })
     */
    private $prospetto;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDataDdt(): ?\DateTimeInterface
    {
        return $this->dataDdt;
    }

    public function setDataDdt(\DateTimeInterface $dataDdt): self
    {
        $this->dataDdt = $dataDdt;

        return $this;
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

    public function getNumeroDdt(): ?string
    {
        return $this->numeroDdt;
    }

    public function setNumeroDdt(?string $numeroDdt): self
    {
        $this->numeroDdt = $numeroDdt;

        return $this;
    }

    public function getQuantita(): ?int
    {
        return $this->quantita;
    }

    public function setQuantita(?int $quantita): self
    {
        $this->quantita = $quantita;

        return $this;
    }

    public function getPrezzo()
    {
        return $this->prezzo;
    }

    public function setPrezzo($prezzo): self
    {
        $this->prezzo = $prezzo;

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

    public function getPeso(): ?int
    {
        return $this->peso;
    }

    public function setPeso(?int $peso): self
    {
        $this->peso = $peso;

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

    public function getAutomezzo(): ?Automezzi
    {
        return $this->automezzo;
    }

    public function setAutomezzo(?Automezzi $automezzo): self
    {
        $this->automezzo = $automezzo;

        return $this;
    }

    public function getCliente(): ?Clienti
    {
        return $this->cliente;
    }

    public function setCliente(?Clienti $cliente): self
    {
        $this->cliente = $cliente;

        return $this;
    }

    public function getFattura(): ?Fatture
    {
        return $this->fattura;
    }

    public function setFattura(?Fatture $fattura): self
    {
        $this->fattura = $fattura;

        return $this;
    }

    public function getProspetto(): ?ProspettiViaggi
    {
        return $this->prospetto;
    }

    public function setProspetto(?ProspettiViaggi $prospetto): self
    {
        $this->prospetto = $prospetto;

        return $this;
    }


}
