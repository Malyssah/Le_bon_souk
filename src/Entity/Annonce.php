<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass="App\Repository\AnnonceRepository")
 */
class Annonce
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Le titre doit être de {{ limit }} charactère minimum",
     *      maxMessage = "Le titre doit être de {{ limit }} charactère maximum")
     */
    private $Nom;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(
     * min=20,
     * minMessage="Le contenu doit être de {{ limit }} charactère minimum")
     */
    private $Contenu;

    /**
     * @ORM\Column(type="datetime")
     */
    private $Date_creation;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\GreaterThan(
     * "today") lessmessage="Vous ne pouvez pas choisir une date anterieur a aujourd'hui)

     */
    private $Date_Validite;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $rubid;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $userid;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->Contenu;
    }

    public function setContenu(string $Contenu): self
    {
        $this->Contenu = $Contenu;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->Date_creation;
    }

    public function setDateCreation(\DateTimeInterface $Date_creation): self
    {
        $this->Date_creation = $Date_creation;

        return $this;
    }

    public function getDateValidite(): ?\DateTimeInterface
    {
        return $this->Date_Validite;
    }

    public function setDateValidite(\DateTimeInterface $Date_Validite): self
    {
        $this->Date_Validite = $Date_Validite;

        return $this;
    }

    public function getRubId(): ?int
    {
        return $this->rubid;
    }

    public function setRubId(?int $rubid): self
    {
        $this->rubid = $rubid;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->userid;
    }

    public function setUserId(?int $userid): self
    {
        $this->userid = $userid;

        return $this;
    }
}
