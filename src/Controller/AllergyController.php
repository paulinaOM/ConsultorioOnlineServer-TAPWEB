<?php

namespace App\Controller;

use App\Repository\AllergyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AllergyController
{
    //constructor
    private $allergyRepository;
    public function __construct(AllergyRepository $allergyRepository){
        $this->allergyRepository=$allergyRepository;
    }

    /**
     * @Route("/allergy", name="getAllAllergies", methods={"GET"})
     */
    public function  getAll():JsonResponse{
        $allergies=$this->allergyRepository->findAll();
        $data=Array();
        foreach ($allergies as $allergy){
            $data[]=[
                'id'=>$allergy->getId(),
                'description'=>$allergy->getDescription(),
            ];
        }
        return new JsonResponse($data,Response::HTTP_OK);
    }

    /**
     * @Route("/allergy/{id}", name="getOneAllergy", methods={"GET"})
     */
    public function  get($id):JsonResponse{
        $allergy=$this->allergyRepository->findOneBy(['id' => $id]);

        if ($allergy){
            $data=[
                'id'=>$allergy->getId(),
                'description'=>$allergy->getDescription(),
            ];

            return new JsonResponse($data,Response::HTTP_OK);
        }
        else{
            return new JsonResponse(['status'=>'No encontrado'],Response::HTTP_NOT_FOUND);
        }

    }
}
