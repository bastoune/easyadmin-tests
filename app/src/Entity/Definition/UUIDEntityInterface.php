<?php
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
     * @return Uuid
     */
    public function getId();
}
