<?php
/**
 * @author Bastien SANDER <bastien@heyliot.com>
 * @copyright 2020 Heyliot (http://www.heyliot.com)
 */

namespace App\Forms\CustomFields;

use App\Enums\CssClass;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

final class UUIDField implements FieldInterface
{
    use FieldTrait;

    public static function create(string $propertyName, string $pageName, ?string $label = null, bool $manualSet = false)
    {
        if ($pageName === Crud::PAGE_NEW) {
            return $manualSet ?
                TextField::new($propertyName, $label) :
                self::new($propertyName, $label);
        }

        if ($pageName === Crud::PAGE_INDEX) {
            return TextField::new($propertyName, $label)
                ->setTemplatePath('admin/custom_fields/uuid_index.html.twig')
                ->formatValue(function ($value) {
                    $suffix = strlen($value) > 5 ? '...' : '';
                    return substr($value, 0, 5) . $suffix;
                })
                ->setCssClass(CssClass::COPY_CSS_CLASS)
                ;
        }

        return self::new($propertyName, $label);
    }

    public static function new(string $propertyName, ?string $label = null): TextField
    {
        return
            TextField::new($propertyName, $label)
                ->setFormTypeOption('disabled', true)
                ->setFormTypeOption('attr', ['placeholder' => 'Auto-Generated'])
        ;
    }
}
