<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('email'),
            TextField::new('username'),
            ChoiceField::new('roles', 'Roles')->setChoices(['USER' => 'ROLE_USER', 'ADMIN' => 'ROLE_ADMIN'])->allowMultipleChoices(),
            TextField::new('adresse'),
            DateTimeField::new('bornAT')->setFormat('dd/MM/yyyy'),
            ImageField::new('image', 'Image article')->setUploadDir("public/images/users")->setBasePath('images/users/')
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->remove(Crud::PAGE_INDEX,Action::NEW)
        ;
    }

}
