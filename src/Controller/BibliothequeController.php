<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BibliothequeController extends AbstractController
{

    #[Route('/bibliotheque', name: 'bibliotheque_lectures')]
    public function bibliotheque_lectures(): Response
    {
        return $this->render('bibliotheque/lectures-cours.html.twig', []);
    }

    #[Route('/bibliotheque/liste', name: 'bibliotheque_liste')]
    public function bibliotheque_liste(): Response
    {
        return $this->render('bibliotheque/liste_lectures.html.twig', []);
    }

    #[Route('/bibliotheque/exemple', name: 'bibliotheque_exemple')]
    public function bibliotheque_exemple(): Response
    {
        return $this->render('bibliotheque/exemple_liste.html.twig', []);
    }

    #[Route('/bibliotheque/livre', name: 'bibliotheque_livre')]
    public function bibliotheque_livre(): Response
    {
        return $this->render('bibliotheque/livre1.html.twig', []);
    }

    #[Route('/bibliotheque/audio', name: 'bibliotheque_audio')]
    public function bibliotheque_audio(): Response
    {
        return $this->render('bibliotheque/livre_audio.html.twig', []);
    }
}
