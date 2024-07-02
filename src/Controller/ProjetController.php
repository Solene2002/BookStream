<?php

namespace App\Controller;

use App\Repository\ProjetRepository;
use App\Service\MySqlService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProjetController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function home(ProjetRepository $projetRepository,MySqlService $mySqlService): Response
    {
        
        $slogan="";
        $projet=$projetRepository->findOneBy(['name'=>'slogan']);
        if($projet){
            $slogan=$projet->getValue();
        }

        $presentation="";
        $projet=$projetRepository->findOneBy(['name'=>'presentation']);
        if($projet){
            $presentation=$projet->getValue();
        }
        

        return $this->render('projet/home.html.twig', [ 
                'slogan'=>$slogan,
                'presentation'=>$presentation,
             ]
        );
    }

    


}
