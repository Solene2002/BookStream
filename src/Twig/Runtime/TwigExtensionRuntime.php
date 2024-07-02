<?php

namespace App\Twig\Runtime;

use Twig\Extension\RuntimeExtensionInterface;

class TwigExtensionRuntime implements RuntimeExtensionInterface
{
    public function __construct()
    {
        // Inject dependencies if needed
    }

    public function getenv($value)
    {
        $retour=$_ENV[$value];
        return $retour;
    }

    public function ajoutPoint($contenu){

        $contenu=strip_tags($contenu);
        $phrase=substr($contenu,0,15);
        $phrase=$phrase.'.....';

        return $phrase;

    }
}
