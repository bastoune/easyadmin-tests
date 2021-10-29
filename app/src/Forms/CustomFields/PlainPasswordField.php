<?php
/**
 * @author Bastien SANDER <bastien@heyliot.com>
 * @copyright 2020 Heyliot (http://www.heyliot.com)
 */

namespace App\Forms\CustomFields;


use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class PlainPasswordField implements FieldInterface
{
    use FieldTrait;

    public static function new(string $propertyName, ?string $label = null)
    {
        $label = $label ?? ucfirst($propertyName);
        return TextField::new($propertyName, $label)
            ->setFormType(RepeatedType::class)
            ->setFormTypeOptions([
                'first_options'  => ['label' => "$label"],
                'second_options' => ['label' => "Repeat the $label"]
            ]);
    }
}