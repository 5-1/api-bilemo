<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CustomerRepository")
 *
 * @Hateoas\Relation(
 *     "self",
 *     href=@Hateoas\Route(
 *     "app_customer_show",
 *     parameters={"id" = "expr(object.getId())"},
 *     absolute=true
 *     )
 * )
 *
 * @Hateoas\Relation(
 *     "modify",
 *     href=@Hateoas\Route(
 *     "app_customer_update",
 *     parameters={"id" = "expr(object.getId())"},
 *     absolute=true
 *     )
 * )
 *
 * @Hateoas\Relation(
 *     "delete",
 *     href=@Hateoas\Route(
 *     "app_customer_delete",
 *     parameters={"id" = "expr(object.getId())"},
 *     absolute=true
 *     )
 * )
 *
 * @Hateoas\Relation(
 *     "user",
 *     embedded = @Hateoas\Embedded("expr(object.getUser())")
 * )
 */
class Customer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Serializer\Expose
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     *
     * @Assert\NotBlank(message="Username cannot be blank")
     * @Assert\Length(
     *      min="5",
     *     max="12",
     *     minMessage="The username must be at least {{ limit }} characters long",
     *     maxMessage="The username cannot be longer than {{ limit }} characters"
     * )
     *
     * @Serializer\Expose
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     *
     * @Assert\NotBlank(message="Email cannot be null")
     * @Assert\Email(
     *     message="The email '{{ value }}' is not a valid email"
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $first_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $second_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $token;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="customers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $User;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
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

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }
}
