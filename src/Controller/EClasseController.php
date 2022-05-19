<?php

namespace App\Controller;

use App\Entity\Classe;
use App\Form\ClasseType;
use App\Repository\ClasseRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EClasseController extends AbstractController
{
    /**
     * @Route("/e/classe", name="ecole_classe_home")
     */
    public function index(ClasseRepository $classeReposi): Response
    {
        $classe = $classeReposi->findAll();
        return $this->render('e_classe/index.html.twig', [
            'classes' => $classe
        ]);
    }

    /**
     * @Route("/e/classe/ajout", name="ecole_classe_ajout")
     */
    public function add(Request $request, ManagerRegistry $managerRegistry): Response
    {
        $classe = new Classe();

        $form = $this->createForm(ClasseType::class, $classe);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $classe = $form->getData();

            $em = $managerRegistry->getManager();
            $em->persist($classe);
            $em->flush();

            $this->addFlash(
                'message',
                'Classe ajouter avec success'
            );

            return $this->redirectToRoute('ecole_classe_home');
        }

        return $this->render('e_classe/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/e/classe/modifier/{id}", name="ecole_classe_modifier")
     */
    public function edit(Classe $classe, Request $request, ManagerRegistry $managerRegistry): Response
    {
        $form = $this->createForm(ClasseType::class, $classe);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $classe = $form->getData();

            $em = $managerRegistry->getManager();
            $em->persist($classe);
            $em->flush();

            $this->addFlash(
                'message',
                'Classe Modifier avec success'
            );

            return $this->redirectToRoute('ecole_classe_home');
        }

        return $this->render('e_classe/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/e/classe/supprimer/{id}", name="ecole_classe_delete")
     */
    public function delete(Classe $classe, ClasseRepository $classsRepo): Response
    {

        $classsRepo->remove($classe, true);

        $this->addFlash(
            'message',
            'Classe supprimer avec success'
        );

        return $this->redirectToRoute('ecole_classe_home');
    }
}
