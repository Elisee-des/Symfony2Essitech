<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\EleveRepository;
use App\Repository\NoteRepository;
use phpDocumentor\Reflection\Types\Parent_;
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

    /**
     * @Route("/p/eleve", name="parent_eleve_liste")
     */
    public function eleve(): Response
    {
        /**
         * @var User
        */

        $parent = $this->getUser();
        $eleves = $parent->getEleves();

        return $this->render('p_dashboard/eleve.html.twig', [
            "eleves" => $eleves
        ]);
    }

    /**
     * @Route("/p/eleve/{id}", name="parent_eleve_note")
     */
    public function note($id, EleveRepository $eleveRepository): Response
    {
        /**
         * @var Eleve
        */
        $eleve = $eleveRepository->find($id);
        $notes = $eleve->getNotes();

        if($eleve->getParent()->getId() != $this->getUser()->getId()){
            return $this->redirectToRoute('parent_dashboard');
        }

        return $this->render('p_dashboard/noteEleve.html.twig', [
            "notes" => $notes,
            "eleve" => $eleve
        ]);
    }
}
