<?php

namespace App\Controller\Admin;

use App\Entity\Etat;
use App\Entity\User;
use App\Entity\Livre;
use App\Entity\Comment;
use App\Entity\Category;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route('admin/', name:'admin')]
    #[IsGranted('ROLE_ADMIN')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('BookStream');
    }

    public function configureMenuItems(): iterable
    {
            yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
            yield MenuItem::linkToCrud('Livres', 'fas fa-scroll', Livre::class);
            yield MenuItem::linkToCrud('Catégories', 'fas fa-list', Category::class);
            yield MenuItem::linkToCrud('Commentaires', 'fas fa-list', Comment::class);
        

            yield MenuItem::section('Paramètres');
            yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-user-circle', User::class);
            yield MenuItem::linkToCrud('Etats', 'fas fa-list', Etat::class);


    }

    
}
