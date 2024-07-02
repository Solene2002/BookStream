<?php

namespace App\Controller;

use App\Entity\Alike;
use App\Entity\Livre;
use App\Entity\Comment;
use App\Form\LivreType;
use App\Form\CommentType;
use App\Repository\AlikeRepository;
use App\Repository\LivreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class LivreController extends AbstractController
{
    #[Route('/livres', name: 'livre_index')]
    public function livre_index(LivreRepository $livreRepository,Request $request ):Response
    {

        $offset=$request->query->getInt('offset',0);
        $paginator=$livreRepository->getLivrePaginator($offset);


        return $this->render('livre/index.html.twig', [
            'livres' => $paginator,
            'previous'=>$offset-LivreRepository::PAGINATOR_PER_PAGE,
            'next'=>min(count($paginator),$offset+LivreRepository::PAGINATOR_PER_PAGE)

        ]);
    }


    #[Route('/livre/{id}/show', name: 'livre_show')]
    public function article_show(Livre $livre,Request $request,EntityManagerInterface $manager,SessionInterface $sessionInterface):Response
    {
        ////////////////////////ECRITURE SESSION//////////////////////////        
        $lastLivres= $sessionInterface->get('lastLivres',[]);
        if (!in_array($livre->getId(), $lastLivres)) {
            $lastLivres[]=$livre->getId();
        }
        $sessionInterface->set('lastLivres', $lastLivres);
        //////////////////////////////////////////////////////////////////
        
        ////////////////////////ECRITURE COOKIES//////////////////////////
        if($this->getUser()){
            /** @var User */
            $user= $this->getUser();
            $cookie=new Cookie(
                'livreLu_'.$user->getId(),
                $livre->getId(),
                time() + ( 2 * 365 * 24 * 60 * 60)  
            );
            $response=new Response();
            $response->headers->setCookie($cookie);
        }
        /////////////////////////////////////////////////////////        

        $comment=new Comment();
        $formBuilder=$this->createForm(CommentType::class,$comment);

        $formBuilder->handleRequest($request);
        if ($formBuilder->isSubmitted() && $formBuilder->isValid()) {

            $comment->setCreatedAt(new \DateTimeImmutable());
            $comment->setLivre($livre);
            $comment->setUser($this->getUser());

            $manager->persist($comment);
            $manager->flush();

        }

        return $this->render("livre/show.html.twig",[
            'livre'=>$livre,
            'form'=>$formBuilder->createView(),
        ]);
    }

    #[Route('/livre/new', name: 'livre_new')]
    #[IsGranted('ROLE_USER',statusCode:403,message:"vous devez vous connecter pour créer un livre")]
    public function livre_new(Request $request,EntityManagerInterface $manager):Response
    {

        $livre=new Livre();

        $formBuilder=$this->createForm(LivreType::class,$livre);

        $formBuilder->handleRequest($request);
        if ($formBuilder->isSubmitted() && $formBuilder->isValid()) {

            ///////////////////////UPLOAD FICHIER////////////////////

            $file=$formBuilder['fichierimage']->getData();
            
            if ($file) {
                $filename=uniqid().'.'.$file->guessExtension();
                try {
                    $file->move(
                        $this->getParameter('kernel.project_dir')."/public/".$_ENV["CHEMIN_IMAGES_LIVRE"],
                        $filename
                    );
                    $livre->setImage($filename);
                } catch (FileException $e) {
                    $this->addFlash('danger', " L'image n'a pas pu être envoyée ");
                }            
            } else {
               $this->addFlash('danger',"Le fichier image n'a pu être envoyé");
            }
            
            /////////////////////////////////////////////////////////


            $livre->setCreatedAt(new \DateTimeImmutable());
            $livre->setUser($this->getUser());
            $manager->persist($livre);

            $manager->flush();
            
            return $this->redirectToRoute('livre_show',['id'=>$livre->getId()]);

        }


        return $this->render("livre/new.html.twig",[
            'formLivre'=>$formBuilder->createView()
        ]);
    }

   

}