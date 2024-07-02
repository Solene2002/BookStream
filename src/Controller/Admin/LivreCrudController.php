<?php

namespace App\Controller\Admin;

use App\Entity\Livre;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;


class LivreCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Livre::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title','Titre'),
            TextEditorField::new('content','Contenu'),
            AssociationField::new('category','Catégorie'),
            AssociationField::new('user','Utilisateur'),
            AssociationField::new('etat','Etat'),
            ImageField::new('image','Image du Livre')->setUploadDir("public/images/")->setBasePath('images/'),
        ];
    }

    
}