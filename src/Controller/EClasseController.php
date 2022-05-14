<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EClasseController extends AbstractController
{
    /**
     * @Route("/e/classe", name="ecole_classe")
     */
    public function index(): Response
    {
        return $this->render('e_classe/index.html.twig', [
            'controller_name' => 'EClasseController',
        ]);
    }
}
