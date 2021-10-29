<?php

namespace App\Entity\Definition;
use App\Entity\Core\User;
use Symfony\Component\Security\Core\User\UserInterface;


trait AuthenticableTrait
{
    private $profile;

    /**
     * @param array $roles
     * @return User
     * @see UserInterface
     */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
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