<?php

namespace App\Controller;

use App\Repository\ConsultationServiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ConsultationServiceController
 * @package App\Controller*
 *

 */


class ConsultationServiceController
{
    //constructor
    private $consultationServiceRepository;
    public function __construct(ConsultationServiceRepository $consultationServiceRepository){
        $this->consultationServiceRepository=$consultationServiceRepository;
    }
    /**
     * @Route("/consultationService", name="consultationService", methods={"POST"})
     */
    public function add(Request $request): JsonResponse
    {
        $data=json_decode($request->getContent(),true);
        $id_consultation=$data['id_consultation'];
        $id_service=$data['id_service'];


        if(empty($id_consultation)||empty($id_service)){
            throw  new NotFoundHttpException("Se esperaban parámetros");
        }
        $this->consultationServiceRepository->saveConsultationService($id_consultation,$id_service);
        return new JsonResponse(['status'=>'ConsultationService creado'],Response::HTTP_CREATED);
    }
    /**
     * @Route("/consultationService", name="getAllConsultationServices", methods={"GET"})
     */
    public function  getAll():JsonResponse{
        $consultationServices=$this->consultationServiceRepository->findAll();
        $data=Array();
        foreach ($consultationServices as $consultationService){
            $data[]=[
                'id'=>$consultationService->getId(),
                'id_consultation'=>$consultationService->getIdConsultation()->getId(),
                'id_service'=>$consultationService->getIdService()->getId(),

            ];
        }
        return new JsonResponse($data,Response::HTTP_OK);

    }
    /**
     * @Route("/consultationService/{id}", name="getOneConsultationService", methods={"GET"})
     */
    public function showAction($id)
    {
        $consultationService = $this->consultationServiceRepository->find($id);
        if (!$consultationService) {
            throw  new NotFoundHttpException("No existe una consulta con un servicio con ese id");
        }
        $data=Array(
            'id'=>$consultationService->getId(),
            'id_consultation'=>$consultationService->getIdConsultation()->getId(),
            'id_service'=>$consultationService->getIdService()->getId(),

        );

        return new JsonResponse($data,Response::HTTP_OK);


    }
}
