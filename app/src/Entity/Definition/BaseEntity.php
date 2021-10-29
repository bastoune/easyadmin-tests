<?php
namespace App\Entity\Definition;

/**
 * Class BaseEntity
 * @package App\Entity
 */
abstract class BaseEntity
{
    use LifeCycleTrait;

    public function __toString(): string
    {
        if (method_exists($this, 'getName') && !is_null($this->getName())) {
            return $this->getName();
        }

        if (method_exists($this, 'getKey') && !is_null($this->getKey())) {
            return $this->getkey();
        }

        if (method_exists($this, 'getId') && !is_null($this->getId())) {
            return (string) $this->getId();
        }

        return '????';
    }
}
