<?php

namespace App\Entity\Core;

use App\Entity\Definition\AuthenticableTrait;
use App\Entity\Definition\UUIDEntityTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Uid\UuidV4;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="`user`")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements PasswordAuthenticatedUserInterface, UserInterface
{
    /**
     * @Groups({"User:read"})
     * @ORM\Id()
     * @ORM\Column(name="id", type="uuid", unique=true)
     */
    private $id;

    /**
     * @Assert\NotNull
     * @Assert\Email
     * @Groups({"User:read", "User:write"})
     *
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @Groups({"User:write"})
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @Groups({"User:read:withRoles"})
     * @ORM\Column(type="array")
     */
    private ?array $roles = [];

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->id = Uuid::v4();
    }

    public function getId(): UuidV4
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
     * @Groups({"User:read"})
     *
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): ?string
    {
        return $this->getEmail();
    }

    public function setRoles(array $roles): self
    {
        $this->roles = array_unique($roles);

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        if (is_null($this->roles)) {
            return ['ROLE_USER'];
        }
        return array_unique(array_merge($this->roles, ['ROLE_USER']));
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function eraseCredentials()
    {
        //no need if no session
    }

    public function __toString(): string
    {
        return $this->getUsername();
    }

    public function addRole(string $role): self
    {
        $this->roles[] = $role;
        $this->roles = array_unique($this->roles);
        return $this;
    }

    public function hasRole(string $role): bool
    {
        return in_array($role, $this->getRoles());
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }
}
