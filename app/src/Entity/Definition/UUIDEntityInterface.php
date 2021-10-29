<?php
/**
 * @author Bastien SANDER <bastien@heyliot.com>
 * @copyright 2020 Heyliot (http://www.heyliot.com)
 */
namespace App\Entity\Definition;

use Symfony\Component\Uid\Uuid;

/**
 * Interface UUIDEntityInterface
 * @package App\Entity\Definition
 */
interface UUIDEntityInterface
{
    /**
     * The String should match the UUIDv4 Regex
     * @see \Heyliot\Helper\StringHelper::UUID_V4_REGEX
     * @return Uuid
     */
    public function getId();
}
