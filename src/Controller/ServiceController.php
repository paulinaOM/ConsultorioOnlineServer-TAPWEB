<?php

namespace App\Controller;

use App\Repository\DoctorRepository;
use App\Repository\ServiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ServiceController
 * @package App\Controller*
 *

 */


class ServiceController
{
    //constructor
    private $serviceRepository;
    public function __construct(ServiceRepository $serviceRepository){

        $this->serviceRepository=$serviceRepository;
    }
    /**
     * @Route("/service", name="service", methods={"POST"})
     */
    public function add(Request $request): JsonResponse
    {
        $data=json_decode($request->getContent(),true);
        $description=$data['description'];


        if(empty($description)){
            throw  new NotFoundHttpException("Se esperaban parámetros");
        }
        $this->serviceRepository->saveService($description);
        return new JsonResponse(['status'=>'Servicio creado'],Response::HTTP_CREATED);
    }
    /**
     * @Route("/service", name="getAllServices", methods={"GET"})
     */
    public function  getAll():JsonResponse{
        $services=$this->serviceRepository->findAll();
        $data=Array();
        foreach ($services as $service){
            $data[]=[
                'id'=>$service->getId(),
                'description'=>$service->getDescription(),

            ];
        }
        return new JsonResponse($data,Response::HTTP_OK);

    }
    /**
     * @Route("/service/{id}", name="getOneService", methods={"GET"})
     */
    public function showAction($id)
    {
        $service = $this->serviceRepository->find($id);
        if (!$service) {
            throw  new NotFoundHttpException("No existe un paciente con ese id");
        }
        $data=Array(
            'id'=>$service->getId(),
            'description'=>$service->getDescription(),

        );

        return new JsonResponse($data,Response::HTTP_OK);


    }
    /**
     * @Route("/services/last", name="getLastService", methods={"GET"})
     */
    public function  getLast():JsonResponse{
        $lastIdService=$this->serviceRepository->findLast();
        return new JsonResponse($lastIdService,Response::HTTP_OK);
    }

}
