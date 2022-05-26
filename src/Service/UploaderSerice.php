<?php
namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploarderService {

    private $directory;

    private $nouveauNom;
    
    public function __construct($dossier)
    {
        $this->directory = $dossier;
    }

    public function uploader(UploadedFile $fichier, $nom=null)
    {
        if (!$nom) {
            $nom = uniqid();
        }

        $nouveauNom = $nom.".".$fichier->guessExtension();
        $fichier->move($this->directory, $nouveauNom);
        
        return $nouveauNom;
    }
}