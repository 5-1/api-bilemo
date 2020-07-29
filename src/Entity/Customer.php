<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Hateoas\Configuration\Annotation as Hateoas;

use JMS\Serializer\Annotation as Serializer;


/**
 * @ORM\Entity(repositoryClass="App\Repository\CustomerRepository")
 * @Hateoas\Relation(
 *     "list",
 *     href=@Hateoas\Route(
 *     "app_customer_list",
 *     absolute=true
 *     ),
 * exclusion = @Hateoas\Exclusion(groups = {"show","create"})
 * )
 *
 * @Hateoas\Relation(
 *     "self",
 *     href=@Hateoas\Route(
 *     "app_customer_show",
 *     parameters={"id" = "expr(object.getId())"},
 *     absolute=true
 *     ),
 * exclusion = @Hateoas\Exclusion(groups = {"list"})
 * )
 *
 * @Hateoas\Relation(
 *     "create",
 *     href=@Hateoas\Route(
 *     "app_customer_create",
 *     absolute=true
 *     ),
 * exclusion = @Hateoas\Exclusion(groups = {"list"})
 * )
 *
 * @Hateoas\Relation(
 *     "delete",
 *     href=@Hateoas\Route(
 *     "app_customer_delete",
 *     parameters={"id" = "expr(object.getId())"},
 *     absolute=true
 *     ),
 * exclusion = @Hateoas\Exclusion(groups = {"list"})
 * )
 */

class Customer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Serializer\Groups({"create","show","list"})
   */
    private $id;


    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Email cannot be null",groups={"create"})
     * @Serializer\Groups({"create","show"})
     * @Assert\Email(groups={"create"},
     *     message="The email '{{ value }}' is not a valid email")
     *
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(groups={"create"})
     * @Assert\Length(min="1", groups={"create"})
     * @Serializer\Groups({"create","show","list"})
     */
    private $first_name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(groups={"create"})
     * @Assert\Length(min="1", groups={"create"})
     * @Serializer\Groups({"create","show","list"})
     *
     */
    private $second_name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="customers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): self
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getSecondName(): ?string
    {
        return $this->second_name;
    }

    public function setSecondName(string $second_name): self
    {
        $this->second_name = $second_name;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

}