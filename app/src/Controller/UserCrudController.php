<?php

namespace App\Controller;

use App\Enums\CssClass;
use App\Forms\CustomFields\PlainPasswordField;
use App\Forms\CustomFields\UUIDField;
use App\Entity\Core\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Traversable;

class UserCrudController extends AbstractBaseCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function getFields(string $pageName): Traversable
    {
        yield TextField::new('id');
//        yield TextField::new('firstName');
//        yield TextField::new('lastName');
//        yield TextField::new('email');
//
//        yield AssociationField::new('profile')->setRequired(true);
//
//        yield PlainPasswordField::new('password')
//            ->hideOnIndex()
//            ->setRequired($pageName === Crud::PAGE_NEW);
//
//        yield TelephoneField::new('phone');
//
//        yield AssociationField::new('language')->hideOnIndex();
//        yield AssociationField::new('organization');
//        yield AssociationField::new('apps');
    }

//    public function configureCrud(Crud $crud): Crud
//    {
//        return $this->getDefaultCrudConfiguration($crud)
//            ->setSearchFields(['id', 'firstName', 'lastName', 'email', 'organization.name'])
//            ->setHelp(Crud::PAGE_INDEX, 'Search by id, firstName, lastName, email, organization.name')
//            ;
//    }
}
