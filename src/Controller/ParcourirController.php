<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ParcourirController extends AbstractController
{
    #[Route('/parcourir', name: 'parcourir_index')]
    public function parcourir_index(): Response
    {
        return $this->render('parcourir/index.html.twig', [

        ]);
    }
}
