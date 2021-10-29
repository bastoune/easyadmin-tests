<?php
namespace App\Entity\Definition;

use Exception;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Uid\UuidV4;

trait UUIDEntityTrait
{
    private $id;

    public function __construct()
    {
        $this->generateUUId();
    }

    /**
     * @throws Exception
     */
    protected function generateUUId($property = 'id')
    {
        if (property_exists(self::class, $property)) {
            $this->id = Uuid::v4();
        } else {
            throw new Exception("Wont generate an id for the dynamic property $property");
        }
    }

    public function getId(): UuidV4
    {
        return $this->id;
    }
}