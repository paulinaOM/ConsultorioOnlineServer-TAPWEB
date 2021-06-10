<?php

namespace App\Controller;

use App\Repository\ChronicDiseaseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChronicDiseaseController
{
    //constructor
    private $chronicDiseaseRepository;
    public function __construct(ChronicDiseaseRepository $chronicDiseaseRepository){
        $this->chronicDiseaseRepository=$chronicDiseaseRepository;
    }

    /**
     * @Route("/chronicdisease", name="getAllChronicDiseases", methods={"GET"})
     */
    public function  getAll():JsonResponse{
        $chronicDiseases=$this->chronicDiseaseRepository->findAll();
        $data=Array();
        foreach ($chronicDiseases as $chronicDisease){
            $data[]=[
                'id'=>$chronicDisease->getId(),
                'description'=>$chronicDisease->getDescription(),
            ];
        }
        return new JsonResponse($data,Response::HTTP_OK);
    }

    /**
     * @Route("/chronicdisease/{id}", name="getOneChronicDisease", methods={"GET"})
     */
    public function  get($id):JsonResponse{
        $chronicDisease=$this->chronicDiseaseRepository->findOneBy(['id' => $id]);

        if ($chronicDisease){
            $data=[
                'id'=>$chronicDisease->getId(),
                'description'=>$chronicDisease->getDescription(),
            ];

            return new JsonResponse($data,Response::HTTP_OK);
        }
        else{
            return new JsonResponse(['status'=>'Enfermedad cronica no encontrada'],Response::HTTP_NOT_FOUND);
        }

    }
}


