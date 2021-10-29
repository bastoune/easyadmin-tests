<?php
/**
 * @author Bastien SANDER <bastien@heyliot.com>
 * @copyright 2020 Heyliot (http://www.heyliot.com)
 */

namespace App\Entity\Definition;

use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Interface AuthenticableInterface
 * @package App\Entity\Definition
 *
 * @method bool|int canCreateUser(?int $minLevel = null)
 * @method bool|int canReadUser(?int $minLevel = null)
 * @method bool|int canUpdateUser(?int $minLevel = null)
 * @method bool|int canDeleteUser(?int $minLevel = null)
 *
 * @method bool|int canCreateOrganization(?int $minLevel = null)
 * @method bool|int canReadOrganization(?int $minLevel = null)
 * @method bool|int canUpdateOrganization(?int $minLevel = null)
 * @method bool|int canDeleteOrganization(?int $minLevel = null)
 *
 * @method bool|int canCreateSensor(?int $minLevel = null)
 * @method bool|int canReadSensor(?int $minLevel = null)
 * @method bool|int canUpdateSensor(?int $minLevel = null)
 * @method bool|int canDeleteSensor(?int $minLevel = null)
 *
 * @method bool|int canCreateContainer(?int $minLevel = null)
 * @method bool|int canReadContainer(?int $minLevel = null)
 * @method bool|int canUpdateContainer(?int $minLevel = null)
 * @method bool|int canDeleteContainer(?int $minLevel = null)
 */
interface AuthenticableInterface extends UserInterface, PasswordAuthenticatedUserInterface
{
    public function eraseCredentials();
    public function getPassword(): ?string;
    public function getUsername();


    public function getRoles(): array;
    public function hasRole(string $role): bool;


    public function getSalt();

    public function __call($name, $arguments);
}