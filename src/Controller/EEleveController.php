<?php

namespace App\Controller;

use App\Entity\Eleve;
use App\Form\EleveType;
use App\Repository\EleveRepository;
use App\Service\UploaderService;
use App\Service\UploarderService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EEleveController extends AbstractController
{
    /**
     * @Route("/e/eleve", name="ecole_eleve_home")
     */
    public function index(EleveRepository $eleveRepo): Response
    {
        $eleves = $eleveRepo->findAll();
        return $this->render('e_eleve/index.html.twig', [
            'eleves' => $eleves
        ]);
    }

    /**
     * @Route("/e/eleve/ajout", name="ecole_eleve_ajout")
     */
    public function add(Request $request, ManagerRegistry $managerRegistry, EleveRepository $eleveRepo, UploaderService $uploarderService): Response
    {
        $eleve = new Eleve();

        $form = $this->createForm(EleveType::class, $eleve);

        $form->handleRequest($request);

        // if ($form->isSubmitted() && $form->isValid()) {

        //     $photoFile = $form->get("photoFile")->getData();

        //     $nomOrigine = $photoFile->getClientOriginalName();

        //     $nouveauNomPhoto = $eleve->getMatricule() . "." . $photoFile->guessExtension();
        //     // dd($this->getParameter("images_directory"));

        //     $photoFile->move($this->getParameter("images_directory"), $nouveauNomPhoto);

        //     $eleve->setPhoto($nouveauNomPhoto);

        //     $eleveRepo->add($eleve, true);

        //     $eleve = $form->getData();

        //     $em = $managerRegistry->getManager();
        //     $em->persist($eleve);
        //     $em->flush();

        //     $this->addFlash(
        //         'message',
        //         "L'eleve " . $eleve->getNom() . " " . $eleve->getPrenom() . " ajouter avec success"
        //     );

        //     return $this->redirectToRoute('ecole_eleve_home');
        // }

        if ($form->isSubmitted() && $form->isValid()) {

            $photoFile = $form->get("photoFile")->getData();

            $nouveauNomPhoto = $uploarderService->uploader($this->getParameter("images_directory"), $photoFile);

            $eleve->setPhoto($nouveauNomPhoto);

            $eleveRepo->add($eleve, true);

            $eleve = $form->getData();

            $em = $managerRegistry->getManager();
            $em->persist($eleve);
            $em->flush();

            $this->addFlash(
                'message',
                "L'eleve " . $eleve->getNom() . " " . $eleve->getPrenom() . " ajouter avec success"
            );

            return $this->redirectToRoute('ecole_eleve_home');
        }

        return $this->render('e_eleve/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/e/eleve/modifier/{id}", name="ecole_eleve_modifier")
     */
    public function edit(Eleve $eleve, Request $request, ManagerRegistry $managerReg): Response
    {
        $form = $this->createForm(EleveType::class, $eleve);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $eleve = $form->getData();

            $em = $managerReg->getManager();
            $em->persist($eleve);
            $em->flush();

            $this->addFlash(
                'message',
                'eleve Modifier avec success'
            );

            return $this->redirectToRoute('ecole_eleve_home');
        }

        return $this->render('e_eleve/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/e/eleve/supprimer/{id}", name="ecole_eleve_delete")
     */
    public function delete(Eleve $eleve, EleveRepository $eleveRepo): Response
    {

        $eleveRepo->remove($eleve, true);

        $this->addFlash(
            'message',
            'eleve supprimer avec success'
        );

        return $this->redirectToRoute('ecole_eleve_home');
    }
}
