<?php

namespace App\Entity;

use App\Repository\ProduitsRepository;
use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=ProduitsRepository::class)
 * @UniqueEntity(fields="nomProduit", message="Erreur : un produit avec ce nom existe déja !", groups="registration")
 */
class Produits
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min = 4, max = 50, minMessage = "Le nom du produits doit contenir au moins {{ limit }} lettres !", maxMessage = "Le nom du produits doit contenir au maximum {{ limit }} lettres !", groups="All")
     */
    private $nomProduit;

    /**
     * @ORM\Column(type="text")
     */
    private $descriptionProduit;

    /**
     * @ORM\Column(type="float")
     * @Assert\Type(type="integer", message="Le prix {{ value }} n'est pas valide : {{ type }}", groups="All")
     */
    private $prixProduit;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $imageProduit;

    /**
     * @ORM\Column(type="boolean")
     */
    private $stockProduit;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\References", cascade={"persist"})
     * @ORM\JoinColumn (nullable=true)
     */
    private $references;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Distributeur",inversedBy="produit", cascade={"persist"})
     * @ORM\JoinColumn (nullable=true)
     */
    private $distributeurs;

    /**
     * @return mixed
     */
    public function getDistributeurs()
    {
        return $this->distributeurs;
    }

    /**
     * @param mixed $distributeurs
     */
    public function setDistributeurs($distributeurs): void
    {
        $this->distributeurs = $distributeurs;
    }

    /**
     * @return mixed
     */
    public function getReferences()
    {
        return $this->references;
    }

    /**
     * @param mixed $references
     */
    public function setReferences($references): void
    {
        $this->references = $references;
    }

    /**
     * @ORM\ManyToOne(targetEntity=Categories::class)
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $categorie_id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="produits")
     */
    private $utilisateur;

    public function __construct()
    {
        $this->distributeurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomProduit(): ?string
    {
        return $this->nomProduit;
    }

    public function setNomProduit(string $nomProduit): self
    {
        $this->nomProduit = $nomProduit;

        return $this;
    }

    //Ajout des slug
    public function setSlug():string{
        $slugify = new Slugify();
        echo $slugify->slugify($this->nomProduit);
    }

    public function getDescriptionProduit(): ?string
    {
        return $this->descriptionProduit;
    }

    public function setDescriptionProduit(string $descriptionProduit): self
    {
        $this->descriptionProduit = $descriptionProduit;

        return $this;
    }

    public function getPrixProduit(): ?float
    {
        return $this->prixProduit;
    }

    public function setPrixProduit(float $prixProduit): self
    {
        $this->prixProduit = $prixProduit;

        return $this;
    }

    public function getImageProduit(): ?string
    {
        return  $this->imageProduit;
    }

    public function setImageProduit(string $imageProduit): self
    {
        $this->imageProduit = $imageProduit;

        return $this;
    }

    public function getStockProduit(): ?bool
    {
        return $this->stockProduit;
    }

    public function setStockProduit(bool $stockProduit): self
    {
        $this->stockProduit = $stockProduit;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getCategorieId(): ?Categories
    {
        return $this->categorie_id;
    }

    public function setCategorieId(?Categories $categorie_id): self
    {
        $this->categorie_id = $categorie_id;

        return $this;
    }

    public function addDistributeur(Distributeur $distributeur): self
    {
        if (!$this->distributeurs->contains($distributeur)) {
            $this->distributeurs[] = $distributeur;
        }

        return $this;
    }

    public function removeDistributeur(Distributeur $distributeur): self
    {
        $this->distributeurs->removeElement($distributeur);

        return $this;
    }

    public function getUtilisateur(): ?User
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?User $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }


}
