<?php

namespace App\Controller;

use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Traversable;

abstract class AbstractBaseCrudController extends AbstractCrudController
{
    abstract protected function getFields(string $pageName): Traversable;

    public function configureCrud(Crud $crud): Crud
    {
        return $this->getDefaultCrudConfiguration($crud);
    }

    public function configureActions(Actions $actions): Actions
    {
        return $this->getDefaultCrudActions($actions);
    }

    public function getDefaultCrudActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
        ;
    }

    public function getDefaultCrudConfiguration(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_EDIT, 'Edit %entity_label_singular% <small>(%entity_id%)</small>')
            ->setPageTitle(Crud::PAGE_DETAIL, '%entity_label_singular% <small>(%entity_id%)</small>')
            ->setDefaultSort(['updatedAt' => 'DESC', 'createdAt' => 'DESC'])
            ->setPaginatorPageSize(30)
            ->showEntityActionsAsDropdown()
            ;
    }
}
