<?php
namespace App\Service;

use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class MailerService
{

    private $cn;

    public function __construct()
    {
       
    }

    public function send($from,$to,$html)
    {
        //Je récupère les paramètres du serveur SMTP et je prépare le Mailer
        $mailer_dsn=$_ENV["MAILERDSN"];
        $transport=Transport::fromDsn($mailer_dsn);
        $mailer=new Mailer($transport);
        
        //Je prépare le nouveau mail (origine, destinataire et contenu HTML)
        $mail=new Email();
        $mail->from($from);
        $mail->to($to);
        $mail->html($html);   
        //Le mailer envoie le mail         
        try {
            $mailer->send($mail);
            //Si l'envoi réussit je renvoie true
            return (object) array('res'=>true,'retour'=>'');
        } catch (TransportExceptionInterface $e) {
            //Sinon je renvoie faux et un message d'erreur
            return (object) array('res'=>false,'retour'=>$e->getMessage());
        } 
    }

}

//La bibliothèque MYSQL PDO de php doit être activé dans le php.ini
//Les variables sont définies dans le .env
/*
#SERVICE MYSQL PDO
MDATABASE='mysql:host=127.0.0.1;dbname=projet;charset=utf8;port=3308'
MLOGIN='root'
MPASSWORD='root'
*/

//Utilisation dans un controller

	// 	/**
    //  * @Route("/test", name="test")
    //  */
    // 	public function index(MySqlService $mySqlService): Response
    // 	{

    //     //Si la requête n'attend pas de paramètres
    //     $clients=$mySqlService->exec('SELECT * FROM projet');

    //     return $this->render('test/index.html.twig', [
    //         'clients'=>$clients
    //     ]);
    
    // 	}



    //   //Si la requête attend des paramètres
    //   $params=['dept'=>$dept,'genre'=>$genre];
    //   $sql="
    //   SELECT * FROM CLIENT 
    //   WHERE departement =:dept 
    //   AND genre=:genre   
    //   ";
    //   $clients=$mySqlService->exec($sql,$params);


