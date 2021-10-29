<?php

namespace App\Entity\Core;

use App\Entity\Definition\AuthenticableInterface;
use App\Entity\Definition\AuthenticableTrait;
use App\Entity\Definition\BaseEntity;
use App\Entity\Definition\UUIDEntityInterface;
use App\Entity\Definition\UUIDEntityTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="`user`")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User extends BaseEntity implements PasswordAuthenticatedUserInterface, UUIDEntityInterface, AuthenticableInterface
{
    use AuthenticableTrait;
    use UUIDEntityTrait;

    /**
     * @Groups({"User:read"})
     * @ORM\Id()
     * @ORM\Column(name="id", type="uuid", unique=true)
     */
    private $id;

    /**
     * @Assert\NotNull
     * @Groups({"User:read", "User:write"})
     *
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @Assert\NotNull
     * @Groups({"User:read", "User:write"})
     *
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @Assert\NotNull
     * @Assert\Email
     * @Groups({"User:read", "User:write"})
     *
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @Groups({"User:read", "User:write"})
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $phone;

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
     *  @Groups({"User:read:item", "User:write"})
     *
     *  @ORM\Column(type="boolean", options={"default":false})
     */
    private $forceChangePassword = false;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->generateUUId();
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
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

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


    public function getForceChangePassword()
    {
        return $this->forceChangePassword;
    }

    public function setForceChangePassword(bool $forceChangePassword): self
    {
        $this->forceChangePassword = $forceChangePassword;
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
}
