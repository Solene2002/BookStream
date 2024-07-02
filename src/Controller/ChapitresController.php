<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChapitresController extends AbstractController
{
    #[Route('/chapitres', name: 'chapitres_index')]
    public function chapitres_index(): Response
    {
        return $this->render('chapitres/index.html.twig', [
        ]);
    }

    #[Route('/chapitres/audio', name: 'chapitres_audio')]
    public function chapitres_audio(): Response
    {
        return $this->render('chapitres/audio.html.twig', [
        ]);
    }

}
