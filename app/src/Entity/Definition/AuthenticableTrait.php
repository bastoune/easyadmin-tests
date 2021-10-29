<?php
/**
 * @author Bastien SANDER <bastien@heyliot.com>
 * @copyright 2020 Heyliot (http://www.heyliot.com)
 */

namespace App\Entity\Definition;

use App\Entity\Core\User;
use Heyliot\Helper\Enum\PermissionEnum;
use Exception;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Trait AuthenticableTrait
 * @package App\Entity\Definition
 *
 * @see AuthenticableTrait::__call
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

    public function getProfile(): ?Profile
    {
        return $this->profile;
    }

    public function setProfile(Profile $profile): self
    {
        $this->profile = $profile;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * Those are the magical methods "canReadEntity..."
     *
     * @param $name
     * @param mixed $arguments If empty, method will return an int with the Level
     * @return int|bool
     * @throws Exception If method isn't in the validatorArray PermissionEnum::isMagicCallable()
     */
    public function __call($name, $arguments)
    {
        if (PermissionEnum::isMagicCallable($name)) {
            // remove "can" from the string => e.g. $permissionName = 'createOrganization'
            $userPermissionLevel = $this->getProfile()->getPermissionLevel(lcfirst(substr($name, 3)));
            if (empty($arguments) || is_null($arguments[0])) {
                // Return the Level if no argument is given
                return $userPermissionLevel;
            } elseif (is_int($arguments[0])) {
                // Return a boolean if there is an argument (a min value)
                return ($arguments[0] <= $userPermissionLevel);
            }
            throw new Exception(
                "Method '$name' in " . self::class .
                'does not support arguments '. implode(', ', $arguments)
            );
        }

        throw new Exception("Unknown method '$name' in " . self::class);
    }
}