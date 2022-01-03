<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups; 



#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource(normalizationContext:["groups"=>["user:read"]],
              denormalizationContext:["groups"=>["user:write"]]
)]



class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[groups(["user:read"])]
    private $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    #[groups(["user:read", "user:write"])] 
    private $email;

    #[ORM\Column(type: 'json')]
    #[groups(["user:read"])]
    private $roles = [];

    
    /**
     * @var string the hashed password
     * 
     */
    #[ORM\Column(type: 'string')] 
    private $password;

    #[groups(["user:write"])]
    private $plainPassword;

    #[ORM\Column(type: 'string', length: 255)]
    #[groups(["user:read", "user:write"])]
    private $username;

    #[ORM\Column(type: 'string', length: 255)]
    #[groups(["user:read", "user:write"])]
    private $name;

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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
    */
    public function getPlainPassword(): string
    {
        return $this->plainpassword;
    }

    public function setPlainPassword(string $plainpassword): self
    {
        $this->plainpassword = $plainpassword;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
         $this->plainPassword = null;
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
