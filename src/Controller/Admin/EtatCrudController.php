<?php

namespace App\Controller\Admin;

use App\Entity\Etat;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class EtatCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Etat::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('statut'),
            TextareaField::new('description'),
        ];
    }
  
}