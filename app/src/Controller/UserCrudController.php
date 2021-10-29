<?php

namespace App\Controller;

use App\Entity\Core\User;
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
        yield TextField::new('firstName');
        yield TextField::new('lastName');
        yield TextField::new('email');

    }

}
