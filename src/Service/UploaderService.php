<?php
namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class UploaderService
{

    private $params;
 public function __construct(ParameterBagInterface $params)
 {
      $this->params = $params;
 }

    public function upload($file,$dossier)
    {
           //Je prépare un nouveau nom avec la même extension
           $filename=uniqid().'.'.$file->guessExtension();
           //Je le déplace dans le bon dossier
           try {
               $file->move(
                   $this->params->get('kernel.project_dir')."/public/".$dossier,
                   $filename
               );
               //Si le fichier est bien uploadé, je renvoie true et le nouveau nom du fichier
               return (object) array('res'=>true,'retour'=>$filename);
           } catch (FileException $e) {
               // en cas de problème lors de l'upload  on renvoie false et un message d'erreur
               return (object) array('res'=>false,'retour'=>$e->getMessage());
           }    
       
    }

}


