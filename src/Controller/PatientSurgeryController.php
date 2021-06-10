<?php

namespace App\Controller;

use App\Repository\PatientSurgeryRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class PatientSurgeryController
{
    //constructor
    private $patientSurgeryRepository;
    public function __construct(PatientSurgeryRepository $patientSurgeryRepository){
        $this->patientSurgeryRepository=$patientSurgeryRepository;
    }

    /**
     * @Route("/patientsurgery", name="patientSurgery", methods={"POST"})
     */
    public function add(Request $request): JsonResponse
    {
        $data=json_decode($request->getContent(),true);

        $idPatient=$data['idPatient'];
        $idSurgery=$data['idSurgery'];

        if(empty($idPatient)||empty($idSurgery)){
            throw  new NotFoundHttpException("Se esperaban parámetros");
        }
        $this->patientSurgeryRepository->savePatientSurgery($idPatient,$idSurgery);
        return new JsonResponse(['status'=>'Relacion patient-surgery creada'],Response::HTTP_CREATED);
    }

    /**
     * @Route("/patientsurgery", name="getAllPatientSurgery", methods={"GET"})
     */
    public function  getAll():JsonResponse{
        $relationsPatientSurgery=$this->patientSurgeryRepository->findAll();
        $data=Array();
        foreach ($relationsPatientSurgery as $patientSurgery){
            $data[]=[
                'id'=>$patientSurgery->getId(),
                'id_patient'=>$patientSurgery->getIdPatient()->getId(),
                'id_surgery'=> $patientSurgery -> getIdSurgery()->getId(),

            ];
        }
        return new JsonResponse($data,Response::HTTP_OK);
    }

    /**
     * @Route("/patientsurgery/{id}", name="getOnePatientSurgery", methods={"GET"})
     */
    public function  get($id):JsonResponse{
        $patientSurgery=$this->patientSurgeryRepository->findOneBy(['id' => $id]);

        if ($patientSurgery){
            $data=[
                'id'=>$patientSurgery->getId(),
                'id_patient'=>$patientSurgery->getIdPatient()->getId(),
                'id_surgery'=> $patientSurgery -> getIdSurgery()->getId(),
            ];

            return new JsonResponse($data,Response::HTTP_OK);
        }
        else{
            return new JsonResponse(['status'=>'Relacion patient-surgery no encontrada'],Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * @Route("/patient/surgery/{id}", name="getPatientSurgeryById", methods={"GET"})
     */
    public function findSurgery($id)
    {
        $patientSurgeries = $this->patientSurgeryRepository->findManyBySomeField($id);
        if (!$patientSurgeries) {
            //throw  new NotFoundHttpException("No existe un usuario con ese username");
            return new JsonResponse(null,Response::HTTP_OK);
        }
        $data=Array();
        foreach ($patientSurgeries as $patientSurgery){
            $data[]=[
                'id'=> $patientSurgery -> getIdSurgery()->getId(),
                'description'=> $patientSurgery -> getIdSurgery()->getDescription(),
            ];
        }

        return new JsonResponse($data,Response::HTTP_OK);


    }
    /**
     * @Route("/patient/surgery/{id_patient}/{id_surgery}", name="getOnePatientSurgeryByIds", methods={"GET"})
     */
    public function findPatientSurgery($id_patient,$id_surgery)
    {
        $patientSurgery = $this->patientSurgeryRepository->findOneBySomeField($id_patient,$id_surgery);
        if (!$patientSurgery) {
            //throw  new NotFoundHttpException("No existe un usuario con ese username");
            return new JsonResponse(null,Response::HTTP_OK);
        }
        $data=Array(
            'id'=> $patientSurgery -> getIdSurgery()->getId(),
            'description'=> $patientSurgery -> getIdSurgery()->getDescription(),

        );
        return new JsonResponse($data,Response::HTTP_OK);
    }
    /**
     * @Route("/patient/{id_patient}/surgery/{id_surgery}", name="deletePatientSurgery", methods={"DELETE"})
     */
    public function delete($id_patient,$id_surgery):JsonResponse
    {
        $patientSurgery= $this->patientSurgeryRepository->findOneBySomeField($id_patient,$id_surgery);
        if ($patientSurgery){
            $this->patientSurgeryRepository->removePatientSurgery($patientSurgery);
        }
        return new JsonResponse(['status'=> 'PatientSurgery DELETED'], Response::HTTP_OK);
    }

}
