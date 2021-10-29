<?php

namespace App\Entity\Definition;

use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

interface AuthenticableInterface extends UserInterface, PasswordAuthenticatedUserInterface
{
    public function eraseCredentials();
    public function getPassword(): ?string;
    public function getUsername();


    public function getRoles(): array;
    public function hasRole(string $role): bool;


    public function getSalt();

}