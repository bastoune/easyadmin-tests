<?php
/**
 * @author Bastien SANDER <bastien@heyliot.com>
 * @copyright 2020 Heyliot (http://www.heyliot.com)
 */

namespace App\Entity\Definition;


use DateTime;
use Doctrine\ORM\Mapping as ORM;

trait LifeCycleTrait
{
    /**
     * WARNING Do not put group annotation here
     * @ORM\Column(type="datetimetz")
     */
    protected ?DateTime $createdAt = null;

    /**
     * WARNING Do not put group annotation here
     * @ORM\Column(type="datetimetz")
     */
    protected ?DateTime $updatedAt = null;

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTime $datetime): self
    {
        $this->updatedAt = $datetime;

        return $this;
    }

    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $datetime): self
    {
        $this->createdAt = $datetime;

        return $this;
    }

    public function updateTimestamps(): void
    {
        $this->setUpdatedAt(new DateTime('now'));
        if ($this->getCreatedAt() === null) {
            $this->setCreatedAt(new DateTime('now'));
        }
    }
}