<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\MoncompteType;
use App\Form\RegistrationType;
use Symfony\Component\Mime\Email;
use App\Repository\UserRepository;
use App\Service\MailerService;
use App\Service\UploaderService;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecurityController extends AbstractController
{
    #[Route('/registration', name: 'security_registration')]
    public function security_registration(MailerService $mailer,UploaderService $uploader, Request $request,EntityManagerInterface $manager,UserPasswordHasherInterface $hasher): Response
    {
        $user=new User();
        $formBuilder=$this->createForm(RegistrationType::class,$user);

        $formBuilder->handleRequest($request);   
        if ($formBuilder->isSubmitted() && $formBuilder->isValid()) {

            ///////////////////////UPLOAD FICHIER////////////////////

            //Récupérer le fichier qui vient d'être uploadé
            $file=$formBuilder['fichierimage']->getData();
            
            //Je vérifie que j'ai bien un fichier 
            if ($file) {
                //Appel du service UploaderService en passant en paramètre le fichier récupéré et le chemin dans lequel l'envoyer
                $reponse=$uploader->upload($file,$_ENV["CHEMIN_IMAGES_USERS"]);
                if ($reponse->res==1) {
                    //Si l'upload s'est bien passé je stocke le nom de l'image dans le champ image du user
                    $user->setImage($reponse->retour);
                } else {
                    //Sinon j'envoie les messages Flash d'erreur
                    $this->addFlash("danger",$reponse->retour);
                    $this->addFlash("danger"," L'image n'a pas pu être envoyée ");
                }

            }
            
            /////////////////////////////////////////////////////////

            $code=md5(uniqid());
            $user->setCode($code);
            $password=$user->getPassword();
            $hashPassword=$hasher->hashPassword(
                $user,
                $password
            );
            $user->setPassword($hashPassword);
            $user->setRoles(["ROLE_USER"]);
            $manager->persist($user);
            

            ///////////////ENVOI MAIL/////////////////////

            //Appel du service MailerService en passant en paramètre l'email de l'admin, l'email du destinataire et le contenu HTML
            $reponse=$mailer->send($_ENV["EMAILADMIN"],$user->getEmail(),$this->renderView(
                'security/_emailregistration.html.twig',[
                'name'=>$user->getUsername(),
                'code'=>$code
                ]
            ));

            if ($reponse->res) {
                //Si l'envoi du mail s'est bien passé j'envoie un message Flash au nouveau user et j'enregistre ses données 
                $this->addFlash("success","Vous allez recevoir un email de validation pour confirmer votre inscription");
                $manager->flush();
            } else {
                //Sinon j'envoie un message flash avec les erreurs
                $this->addFlash("danger",$reponse->retour);
                $this->addFlash("danger","Votre inscription a échoué");
            }
            
            //////////////////////////////////////////////
            
            return $this->redirectToRoute('security_login');
            
        }

        return $this->render('security/registration.html.twig', [
            'form'=>$formBuilder->createView(),
        ]);
    }

    #[Route('/connexion', name: 'security_login')]
    public function security_login(): Response
    {
       
        return $this->render('security/login.html.twig', [
            
        ]);

    }

    #[Route('/check', name: 'security_check')]
    public function security_check(): Response
    {
        /** @var User */     
        $user=$this->getUser();

        if ($user->getCode()!='') {
           return  $this->redirectToRoute('security_logout');
        } else {
           return  $this->redirectToRoute('home');
        }
        
      

    }

    #[Route('/deconnexion', name: 'security_logout')]
    public function security_logout()
    {     
        
     }

     #[Route('/validation/{code}', name: 'security_validation')]
     public function security_validation($code,UserRepository $repository,EntityManagerInterface $manager)
     {     

        $user=$repository->findOneBy(['code'=>$code]);

        if ($user) {
            $user->setCode('');
            $manager->persist($user);
            $manager->flush();
            $this->addFlash("success","Inscription validée");
        }else{
            $this->addFlash("danger","Inscription non validée");
        }
        
        return $this->redirectToRoute('home');  
    }

    #[Route('/moncompte/{id}', name: 'security_moncompte')]
    public function security_moncompte(User $user,Request $request,UserRepository $repository,EntityManagerInterface $manager,UserPasswordHasherInterface $hasher)
    {     

        $formBuilder=$this->createForm(MoncompteType::class,$user);

        $formBuilder->handleRequest($request);   
        if ($formBuilder->isSubmitted() && $formBuilder->isValid()) {

             ///////////////////////UPLOAD FICHIER////////////////////

            //Récupérer le fichier qui vient d'être uploadé
            $file=$formBuilder['fichierimage']->getData();
            
            //Je vérifie que j'ai bien un fichier image
            if ($file) {
                //Je prépare un nouveau nom avec la même extension
                $filename=uniqid().'.'.$file->guessExtension();
                //Je le déplace dans le bon dossier
                try {
                    $file->move(
                        $this->getParameter('kernel.project_dir')."/public/".$_ENV["CHEMIN_IMAGES_USERS"],
                        $filename
                    );
                    //J'enregistre dans la table le nom du fichier
                    $user->setImage($filename);
                } catch (FileException $e) {
                    // en cas de problème lors du déplacement  on envoie un message d'erreur
                    $this->addFlash('danger', " L'image n'a pas pu être envoyée ");
                }    
            }
            
            /////////////////////////////////////////////////////////

            $password=$user->getPassword();
            $hashPassword=$hasher->hashPassword(
                $user,
                $password
            );
            $user->setPassword($hashPassword);
            $user->setRoles(["ROLE_USER"]);
            dump($user);
            $manager->persist($user);
            $manager->flush();

            //return $this->redirectToRoute('security_login');            
        }
        return $this->render('security/moncompte.html.twig', [
            'form'=>$formBuilder->createView(),
        ]);
   }

}
