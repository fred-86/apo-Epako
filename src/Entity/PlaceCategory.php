<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\PlaceCategoryRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * @ORM\Entity(repositoryClass=PlaceCategoryRepository::class)
 * @Vich\Uploadable
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(
 *   fields={"name"},
 *   message="le nom existe déjà"
 * )
 */
class PlaceCategory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("api_place_browse")
     * @Groups("api_place_read")
     * @Groups("api_place_category_browse")
     * @Groups("api_place_category_read")
     * @Groups("api_placecategory_browse_productcategory")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64, unique=true)
     * @Groups("api_place_browse")
     * @Groups("api_place_read")
     * @Groups("api_place_category_browse")
     * @Groups("api_place_category_read")
     * @Groups("api_placecategory_browse_productcategory")
     * @Assert\NotBlank
     * @Assert\Length(min=2, minMessage="doit contenir au moins 2 caractères")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("api_place_browse")
     * @Groups("api_place_read")
     * @Groups("api_place_category_browse")
     * @Groups("api_place_category_read")
     */
    private $pictogram;

    /**
    * @ORM\Column(type="string", length=255)
    * @var string
    * @Groups("api_place_browse")
    * @Groups("api_place_read")
    * @Groups("api_place_category_browse")
    * @Groups("api_place_category_read")
    */
    private $image;

    /**
     * @Vich\UploadableField(mapping="placecategory_picto", fileNameProperty="image")
     * @var File
     * @Assert\NotBlank
     */
    private $imageFile;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity=Place::class, mappedBy="placeCategory")
     * @Groups("api_place_category_read")
     * @Groups("api_placecategory_browse_productcategory")
     * @Assert\NotBlank
     */
    private $places;

    public function __construct()
    {
        $this->places = new ArrayCollection();
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPictogram(): ?string
    {
        return $this->pictogram;
    }

    public function setPictogram(string $pictogram): self
    {
        $this->pictogram = $pictogram;

        return $this;
    }

    public function setImageFile(?File $imageFile = null)
    {
        $this->imageFile = $imageFile;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if (null !== $imageFile) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImage($image):self
    {
        $this->image = $image;
        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue()
    {
        $this->updatedAt = new \DateTime();
    }

    /**
     * @return Collection|Place[]
     */
    public function getPlaces(): Collection
    {
        return $this->places;
    }

    public function addPlace(Place $place): self
    {
        if (!$this->places->contains($place)) {
            $this->places[] = $place;
            $place->setPlaceCategory($this);
        }

        return $this;
    }

    public function removePlace(Place $place): self
    {
        if ($this->places->removeElement($place)) {
            // set the owning side to null (unless already changed)
            if ($place->getPlaceCategory() === $this) {
                $place->setPlaceCategory(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }
}
