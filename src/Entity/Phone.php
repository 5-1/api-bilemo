<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Hateoas\Configuration\Annotation as Hateoas;
use JMS\Serializer\Annotation as Serializer;


/**
 * @ORM\Entity(repositoryClass="App\Repository\PhoneRepository")
 *
 * @Hateoas\Relation(
 *     "self",
 *     href=@Hateoas\Route(
 *     "app_phone_show",
 *     parameters={"id" = "expr(object.getId())"},
 *     absolute=true
 *     )
 * )
 */
class Phone
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Serializer\Since("1.0")
     * @Serializer\Expose
     *
     */
    private $model;


    /**
     * @ORM\Column(type="text")
     *
     * @Serializer\Since("1.0")
     * @Serializer\Expose
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Serializer\Since("1.0")
     * @Serializer\Expose
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Serializer\Since("1.0")
     * @Serializer\Expose
     */
    private $color;

    /**
     * @ORM\Column(type="integer")
     *
     * @Serializer\Since("1.0")
     * @Serializer\Expose
     */
    private $stock;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Brand", inversedBy="phones")
     * @ORM\JoinColumn(nullable=false)
     *
     * @Serializer\Since("1.0")
     * @Serializer\Expose
     */
    private $brand;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }


    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    public function setBrand(?Brand $brand): self
    {
        $this->brand = $brand;

        return $this;
    }
}
