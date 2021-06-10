<?php

namespace App\Controller;

use App\Repository\DoctorServiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class DoctorServiceController
 * @package App\Controller*
 *

 */


class DoctorServiceController
{
    //constructor
    private $doctorServiceRepository;
    public function __construct(DoctorServiceRepository $doctorServiceRepository){
        $this->doctorServiceRepository=$doctorServiceRepository;
    }
    /**
     * @Route("/doctorService", name="doctorService", methods={"POST"})
     */
    public function add(Request $request): JsonResponse
    {
        $data=json_decode($request->getContent(),true);
        $id_doctor=$data['id_doctor'];
        $id_service=$data['id_service'];
        $cost=$data['cost'];


        if(empty($id_doctor)||empty($id_service)||empty($cost)){
            throw  new NotFoundHttpException("Se esperaban parámetros");
        }
        $this->doctorServiceRepository->saveDoctorService($id_doctor,$id_service,$cost);
        return new JsonResponse(['status'=>'DoctorService creado'],Response::HTTP_CREATED);
    }
    /**
     * @Route("/doctorService", name="getAllDoctorServices", methods={"GET"})
     */
    public function  getAll():JsonResponse{
        $doctorServices=$this->doctorServiceRepository->findAll();
        $data=Array();
        foreach ($doctorServices as $doctorService){
            $data[]=[
                'id'=>$doctorService->getId(),
                'id_doctor'=>$doctorService->getIdDoctor()->getId(),
                'id_service'=>$doctorService->getIdService()->getId(),
                'cost'=>$doctorService->getCost(),

            ];
        }
        return new JsonResponse($data,Response::HTTP_OK);

    }
    /**
     * @Route("/doctorService/{id}", name="getOneDS", methods={"GET"})
     */
    public function showAction($id)
    {
        $doctorService = $this->doctorServiceRepository->find($id);
        if (!$doctorService) {
            throw  new NotFoundHttpException("No existe un doctor ni servicio con ese id");
        }
        $data=Array(
            'id'=>$doctorService->getId(),
            'id_doctor'=>$doctorService->getIdDoctor()->getId(),
            'id_service'=>$doctorService->getIdService()->getId(),
            'cost'=>$doctorService->getCost(),

        );

        return new JsonResponse($data,Response::HTTP_OK);


    }
    /**
     * @Route("/doctorService/edit/{id}", name="updateDoctorService", methods={"PUT"})
     */
    public function update($id, Request $request):JsonResponse
    {
        $doctorService= $this->doctorServiceRepository->findOneBy(['id'=>$id]);
        $data = json_decode($request->getContent(), true);

        empty($data['cost'])? true : $doctorService->setCost($data['cost']);

        $this->doctorServiceRepository->updateDoctorService($doctorService);

        return new JsonResponse(['status'=> 'DoctorService updated'], Response::HTTP_OK);
    }

    /**
     * @Route("/doctorService/{id}", name="deleteDoctorService", methods={"DELETE"})
     */
    public function delete($id):JsonResponse
    {
        $doctorService= $this->doctorServiceRepository->findOneBy(['id'=>$id]);

        $this->doctorServiceRepository->removeDoctorService($doctorService);

        return new JsonResponse(['status'=> 'DoctorService DELETED'], Response::HTTP_OK);
    }
    /**
     * @Route("/services/doctor/{id}", name="getServicesByDoctor", methods={"GET"})
     */
    public function  getServicesByDoctor($id):JsonResponse{
        $doctorServices=$this->doctorServiceRepository->findBy(["doctor"=>$id]);
        $data=Array();
        foreach ($doctorServices as $doctorService){
            $data[]=[
                'id'=>$doctorService->getId(),
                'id_doctor'=>$doctorService->getIdDoctor()->getId(),
                'id_service'=>$doctorService->getIdService()->getId(),
                'description' =>$doctorService->getIdService()->getDescription(),
                'cost'=>$doctorService->getCost(),

            ];
        }
        return new JsonResponse($data,Response::HTTP_OK);

    }
    /**
     * @Route("/service/{id_service}/doctor/{id_doctor}", name="getDoctorServiceByIds", methods={"GET"})
     */
    public function findDoctorService($id_service,$id_doctor)
    {
        $doctorService = $this->doctorServiceRepository->findOneBySomeField($id_service,$id_doctor);
        if (!$doctorService) {
            //throw  new NotFoundHttpException("No existe un usuario con ese username");
            return new JsonResponse(null,Response::HTTP_OK);
        }
        $data=Array(
            'id'=>$doctorService->getId(),
            'id_doctor'=>$doctorService->getIdDoctor()->getId(),
            'id_service'=>$doctorService->getIdService()->getId(),
            'description' =>$doctorService->getIdService()->getDescription(),
            'cost'=>$doctorService->getCost(),
        );

        return new JsonResponse($data,Response::HTTP_OK);


    }


}
