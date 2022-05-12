<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/ecole", name="home")
     */
    public function index(): Response
    {
        return $this->render('ecole/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
}   
