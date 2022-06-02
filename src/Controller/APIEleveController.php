<?php

namespace App\Controller;

use App\Entity\Eleve;
use App\Form\EleveType;
use App\Repository\EleveRepository;
use App\Service\UploaderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class APIEleveController extends AbstractController
{
    /**
     * @Route("/api/eleve", name="api_eleve", methods={"GET"})
     */
    public function index(EleveRepository $eleveRepo): Response
    {
        $eleves = $eleveRepo->findAll();

        $tab = [];

        foreach ($eleves as $eleve) {
            $tab = [
                "id" => $eleve->getId(),
                "nom" => $eleve->getNom(),
                "prenom" => $eleve->getPrenom(),
                "parent" => [
                    "id" => $eleve->getParent()->getId(),
                    "nom" => $eleve->getParent()->getNom(),
                    "prenom" => $eleve->getParent()->getPrenom(),
                    "email" => $eleve->getParent()->getEmail(),
                ],
                "classe" => [
                    "id" => $eleve->getClasse()->getId(),
                    "nom" => $eleve->getClasse()->getNom(),
                ],
                "notes" => [],
                "retard" => []
            ];
        }

        return $this->json($tab, 200);
    }

    /**
     * @Route("/api/eleve/add", name="api_eleve", methods={"POST"})
     */
    public function creation(Request $request, EleveRepository $eleveRepo, UploaderService $uploaderService): Response
    {
        $data = $request->getContent();

        
        $dataDecode = json_decode($data, true);
        
        $eleve = new Eleve();
        
        $form = $this->createForm(EleveType::class, $eleve);
        $form->submit($dataDecode);
        
        if ($form->isSubmitted() && $form->isValid()) {

            // $image = $form->get("photo")->getData();
            
            $eleveRepo->add($eleve, true);
            $reponse = ["id" => $eleve->getId()];

            // $nomImage = $uploaderService->uploader($image);

            // $eleve->setPhoto($nomImage);

            return $this->json([
                "status" => true,
                "data" => $reponse
            ], 201);
        }
        dd($eleve);

        return $this->json(["status" => false, "msg" => "Erreur de donnee"]);
    }

    /**
     * @Route("/api/eleve/edition/{id}", name="api_eleve", methods={"PUT"})
     */
    public function edition(Request $request, EleveRepository $eleveRepo, $id): Response
    {

        $eleve = $eleveRepo->find($id);

        if ($eleve) {
            $data = $request->getContent();

            $dataDecode = json_decode($data, true);

            $form = $this->createForm(EleveType::class, $eleve);

            $form->submit($dataDecode, true);

            if ($form->isSubmitted() && $form->isValid()) {

                $eleveRepo->add($eleve, true);

                $reponse = [
                    "id" => $eleve->getId(),
                    "nom" => $eleve->getNom(),
                    "prenom" => $eleve->getPrenom(),

                ];
            }
            return $this->json([
                "status" => true,
                "data" => $reponse
            ], 201);
        }

        return $this->json(["status" => false, "msg" => "Erreur de donnee"]);
    }

    /**
     * @Route("/api/eleve/suppression/{id}", name="api_eleve", methods={"PUT"})
     */
    public function suppression(Request $request, EleveRepository $eleveRepo, $id): Response
    {

        $eleve = $eleveRepo->find($id);

        if ($eleve) {

                $eleveRepo->remove($eleve, true);

                return $this->json(null, 204);

            }

        }

}
