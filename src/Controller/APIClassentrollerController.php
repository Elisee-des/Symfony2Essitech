<?php

namespace App\Controller;

use App\Repository\ClasseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class APIClassentrollerController extends AbstractController
{
    /**
     * @Route("/api/classe", name="api_classentroller", methods={"GET"})
     */
    public function index(ClasseRepository $classeRepo): Response
    {
        $classe = $classeRepo->findAll();
        return $this->json([
            'succes' => true,
            'data' => $classe,
        ]);
    }
}
