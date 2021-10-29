<?php
/**
 * @author Bastien SANDER <bastien@heyliot.com>
 * @copyright 2020 Heyliot (http://www.heyliot.com)
 */

namespace App\Forms\CustomFields;


use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;

class LifecycleDateTimeField implements FieldInterface
{
    use FieldTrait;

    public static function new(string $propertyName, ?string $label = null)
    {
        return CustomDateTimeField::new($propertyName, $label)
            ->setFormTypeOptions(['disabled' => true])
        ;
    }
}
