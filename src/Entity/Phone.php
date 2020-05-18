<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Hateoas\Configuration\Annotation as Hateoas;
use JMS\Serializer\Annotation as Serializer;


/**
 * @ORM\Entity(repositoryClass="App\Repository\PhoneRepository")
 * @ORM\Table()
 *
 * @Hateoas\Relation(
 *     "brand",
 *     embedded = @Hateoas\Embedded("expr(object.getBrand())"),
 * exclusion = @Hateoas\Exclusion(groups = {"show"})
 * )
 * @Hateoas\Relation(
 *     "self",
 *     href=@Hateoas\Route(
 *     "app_phone_show",
 *     parameters={"id" = "expr(object.getId())"},
 *     absolute=true
 *     ),
 * exclusion = @Hateoas\Exclusion(groups = {"show","list"})
 * )
 * @Hateoas\Relation(
 *     "list",
 *     href=@Hateoas\Route(
 *     "app_phone_list",
 *     absolute=true
 *     ),
 * exclusion = @Hateoas\Exclusion(groups = {"show"})
 * )
 */
class Phone
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *
     * @Serializer\Since("1.0")
     * @Serializer\Groups({"list","show"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Serializer\Since("1.0")
     * @Serializer\Groups({"list","show"})
     *
     */
    private $model;


    /**
     * @ORM\Column(type="text")
     * @Serializer\Groups({"show"})
     * @Serializer\Since("1.0")
     */
    private $description;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     * @Serializer\Groups({"show"})
     * @Serializer\Since("1.0")
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Groups({"show"})
     * @Serializer\Since("1.0")
     */
    private $color;

    /**
     * @ORM\Column(type="integer")
     *
     * @Serializer\Since("1.0")
     * @Serializer\Groups({"list"})
     * @Serializer\Groups({"show","list"})
     */
    private $stock;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Brand", inversedBy="phones")
     * @ORM\JoinColumn(nullable=false)
     *
     * @Serializer\Since("1.0")
     * @Serializer\Groups({"show"})
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

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
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
