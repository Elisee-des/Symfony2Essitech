<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiLoginController extends AbstractController
{
    /**
     * @Route("/api/login", name="app_api_login")
     */
    public function index(EntityManagerInterface $em): Response
    {
        $user = $this->getUser();

        if ($user == null) {
            return $this->json(["message"=>"identifiant manquant"], Response::HTTP_UNAUTHORIZED);
        }
        $token = password_hash($user->getEmail(), PASSWORD_DEFAULT);
        
        $user->setApiToken($token);        
        $em->flush();

        return $this->json([
            'user' => $user->getUserIdentifier(),
            'token' => $token,
        ]);
    }
}
