<?php

namespace App\Controller;

use App\Repository\SurgeryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SurgeryController
{
    //constructor
    private $surgeryRepository;
    public function __construct(SurgeryRepository $surgeryRepository){
        $this->surgeryRepository=$surgeryRepository;
    }

    /**
     * @Route("/surgery", name="getAllSurgeries", methods={"GET"})
     */
    public function  getAll():JsonResponse{
        $surgeries=$this->surgeryRepository->findAll();
        $data=Array();
        foreach ($surgeries as $surgery){
            $data[]=[
                'id'=>$surgery->getId(),
                'description'=>$surgery->getDescription(),
            ];
        }
        return new JsonResponse($data,Response::HTTP_OK);
    }

    /**
     * @Route("/surgery/{id}", name="getOneSurgery", methods={"GET"})
     */
    public function  get($id):JsonResponse{
        $surgery=$this->surgeryRepository->findOneBy(['id' => $id]);

        if ($surgery){
            $data=[
                'id'=>$surgery->getId(),
                'description'=>$surgery->getDescription(),
            ];

            return new JsonResponse($data,Response::HTTP_OK);
        }
        else{
            return new JsonResponse(['status'=>'Cirugia no encontrada'],Response::HTTP_NOT_FOUND);
        }

    }
}
