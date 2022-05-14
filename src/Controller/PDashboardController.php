<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PDashboardController extends AbstractController
{
    /**
     * @Route("/p/dashboard", name="parent_dashboard")
     */
    public function index(): Response
    {
        return $this->render('p_dashboard/index.html.twig', [
            'controller_name' => 'PDashboardController',
        ]);
    }
}
