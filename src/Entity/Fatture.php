<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Fatture
 *
 * @ORM\Table(name="fatture", indexes={@ORM\Index(name="id_cliente_fatture_clienti_idx", columns={"cliente_id"})})
 * @ORM\Entity
 */
class Fatture
{
    public function __construct()
    {
        $this->ddts = new ArrayCollection();
    }

    /**
     * @ORM\OneToMany(targetEntity="Ddts", mappedBy="fattura")
     * @ORM\OrderBy({"dataDdt" = "ASC"})
     */
    private $ddts;

    /**
     * @var float
     */
    private $totale;

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
     * @ORM\Column(name="numero_fattura", type="integer", nullable=false)
     */
    private $numeroFattura;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data_fattura", type="datetime", nullable=false)
     */
    private $dataFattura;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="data_mail", type="datetime", nullable=true)
     */
    private $dataMail;

    /**
     * @var string|null
     *
     * @ORM\Column(name="iva", type="decimal", precision=3, scale=1, nullable=true, options={"default"="22.0"})
     */
    private $iva = '22.0';

    /**
     * @var string|null
     *
     * @ORM\Column(name="spesaIncasso", type="decimal", precision=6, scale=2, nullable=true)
     */
    private $spesaincasso;

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

    /**
     * @var string|null
     *
     * @ORM\Column(name="nota_fattura", type="string", length=255, nullable=true)
     */
    private $notaFattura;

    /**
     * @var \Clienti
     *
     * @ORM\ManyToOne(targetEntity="Clienti")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cliente_id", referencedColumnName="id")
     * })
     */
    private $cliente;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroFattura(): ?int
    {
        return $this->numeroFattura;
    }

    public function setNumeroFattura(int $numeroFattura): self
    {
        $this->numeroFattura = $numeroFattura;

        return $this;
    }

    public function getDataFattura(): ?\DateTimeInterface
    {
        return $this->dataFattura;
    }

    public function setDataFattura(\DateTimeInterface $dataFattura): self
    {
        $this->dataFattura = $dataFattura;

        return $this;
    }

    public function getDataMail(): ?\DateTimeInterface
    {
        return $this->dataMail;
    }

    public function setDataMail(?\DateTimeInterface $dataMail): self
    {
        $this->dataMail = $dataMail;

        return $this;
    }

    public function getIva()
    {
        return $this->iva;
    }

    public function setIva($iva): self
    {
        $this->iva = $iva;

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

    public function getLstupd(): ?\DateTimeInterface
    {
        return $this->lstupd;
    }

    public function setLstupd(?\DateTimeInterface $lstupd): self
    {
        $this->lstupd = $lstupd;

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

    public function getCliente(): ?Clienti
    {
        return $this->cliente;
    }

    public function setCliente(?Clienti $cliente): self
    {
        $this->cliente = $cliente;

        return $this;
    }

    /**
     * @return Collection|Ddts[]
     */
    public function getDdts(): Collection
    {
        return $this->ddts;
    }

    public function getTotale(): float
    {
        $totale = 0.0;
        foreach ($this->ddts as $ddt){
            $totale += $ddt->getPrezzo();
        }

        return $totale;
    }

    public function addDdts(Ddts $ddts): self
    {
        if (!$this->ddts->contains($ddts)) {
            $this->ddts[] = $ddts;
            $ddts->setFattura($this);
        }

        return $this;
    }

    public function removeDdts(Ddts $ddts): self
    {
        if ($this->ddts->contains($ddts)) {
            $this->ddts->removeElement($ddts);
            // set the owning side to null (unless already changed)
            if ($ddts->getFattura() === $this) {
                $ddts->setFattura(null);
            }
        }

        return $this;
    }

    public function pdfFileName()
    {
        return sprintf("%s FT %s %s", date("Ymd", $this->dataFattura->getTimestamp()), $this->numeroFattura, str_replace('.','_',$this->cliente->getRagioneSociale()));
    }
}
