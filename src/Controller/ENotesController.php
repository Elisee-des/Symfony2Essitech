<?php

namespace App\Controller;

use App\Entity\Classe;
use App\Entity\Note;
use App\Form\NoteType;
use App\Repository\ClasseRepository;
use App\Repository\NoteRepository;
use App\Service\EnvoieNoteService as ServiceEnvoieNoteService;
use Doctrine\Persistence\ManagerRegistry;
use EnvoieNoteService;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class ENotesController extends AbstractController
{
    /**
     * @Route("/e/notes", name="ecole_notes_home")
     */
    public function index(NoteRepository $noteRepo): Response
    {
        return $this->render('e_notes/index.html.twig', [
            'notes' => $noteRepo->findBy([], ["id" => "DESC"]),
        ]);
    }

    /**
     * @Route("/e/notes/mail", name="ecole_notes_mail")
     */
    public function mail(MailerInterface $mailer)
    {
        $email = new Email();

        $email->from("yemtemasabidani@gmail.com")
            ->to("esabidani@gmail.com")
            ->subject("Text de email")
            ->text("Salut mec ca gaz?");

        $mailer->send($email);

        return $this->redirectToRoute('ecole_notes_home');
    }

    /**
     * @Route("/e/notes/ajout", name="ecole_notes_ajout")
     */
    public function ajout(): Response
    {
        $form = $this->createFormBuilder()
            ->add("matiere", TextType::class)
            ->add("classe", EntityType::class, [
                "class" => Classe::class,

            ])
            ->add("Continuer", SubmitType::class)
            ->setAction($this->generateUrl("ecole_notes_ajout_continuer"))
            ->getForm();

        return $this->render('e_notes/ajoutNote.html.twig', [
            'formulaires' => $form->createView(),
        ]);
    }

    /**
     * @Route("/e/notes/ajout/continuer", name="ecole_notes_ajout_continuer")
     */
    public function ajoutContinuer(Request $request, ClasseRepository $classeRepo, NoteRepository $noteRepo, ManagerRegistry $managerRegi, ServiceEnvoieNoteService $envoieNoteService): Response
    {
        //recuperaion des donne du formulaire
        $dataForm = $request->get("form");
        $matiere = $dataForm["matiere"];
        $classeID = $dataForm["classe"];

        //on recupere les donner de la BD
        $classe = $classeRepo->find($classeID);
        $eleves = $classe->getEleves();

        //on generer le formulaire
        $formBuilder = $this->createFormBuilder();

        foreach ($eleves as $eleve) {
            $label = $eleve->getMatricule() . " - " . $eleve->getNom() . "  " . $eleve->getPrenom();
            $champName = "note_" . $eleve->getID();
            $formBuilder->add($champName, TextType::class, [
                "label" => $label
            ]);
            $formBuilder->add("matiere", HiddenType::class, [
                "attr" => ["value" => $matiere],
            ]);
            $formBuilder->add("classe", HiddenType::class, [
                "attr" => ["value" => $classeID],
            ]);
        }
        //handlrequest

        $formBuilder->add("Enregister", SubmitType::class);
        $form = $formBuilder->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();

            foreach ($eleves as $eleve) {
                $champName = "note_" . $eleve->getID();
                $noteEleve = $data[$champName];

                $note = new Note();
                $note->setMatiere($matiere);
                $note->setEleve($eleve);
                $note->setNote($noteEleve);

                $noteRepo->add($note, true);
                // $em = $managerRegi->getManager();
                // $em->persist($note);
                // $em->flush();

                $tabNotes[] = [
                    "email" => $eleve->getParent()->getEmail(),
                    "note" => $noteEleve,
                    "matiere" => $matiere,
                    "eleve" => $eleve->getPrenom()
                ];
            }

            $envoieNoteService->envoyezNotes($tabNotes);

            $this->addFlash(
                'success',
                'Note enregistre avec success'
            );

            return $this->redirectToRoute('ecole_notes_home');
        }

        //on request
        // dd();
        return $this->render('e_notes/ajout_continuer.html.twig', [
            "formulaire" => $form->createView(),
            "classe" => $classe
        ]);
    }

    /**
     * @Route("/e/note/modifier/{id}", name="ecole_note_modifier") 
     */
    public function edit(Note $note, Request $request, ManagerRegistry $managerRegistry): Response
    {
        $form = $this->createForm(NoteType::class, $note);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $managerRegistry->getManager();
            $em->persist($note);
            $em->flush();

            $this->addFlash(
                'success',
                'Modifier avec success'
            );

            return $this->redirectToRoute('ecole_notes_home');
        }

        return $this->render('e_notes/noteEdit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/e/note/supprimer/{id}", name="ecole_note_delete")
     */
    public function delete(Note $note, NoteRepository $noteRepo): Response
    {

        $noteRepo->remove($note, true);

        $this->addFlash(
            'message',
            'note supprimer avec success'
        );

        return $this->redirectToRoute('ecole_notes_home');
    }
}
