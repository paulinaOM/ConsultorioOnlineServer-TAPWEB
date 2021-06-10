<?php

namespace App\Controller;

use App\Repository\PatientDiseaseRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class PatientDiseaseController
{
    //constructor
    private $patientDiseaseRepository;
    public function __construct(PatientDiseaseRepository $patientDiseaseRepository){
        $this->patientDiseaseRepository=$patientDiseaseRepository;
    }

    /**
     * @Route("/patientdisease", name="patientdisease", methods={"POST"})
     */

    public function add(Request $request): JsonResponse
    {
        $data=json_decode($request->getContent(),true);

        $idPatient=$data['idPatient'];
        $idDisease=$data['idDisease'];

        if(empty($idPatient)||empty($idDisease)){
            throw  new NotFoundHttpException("Se esperaban parámetros");
        }
        $this->patientDiseaseRepository->savePatientDisease($idPatient,$idDisease);
        return new JsonResponse(['status'=>'Relacion patient-disease creada'],Response::HTTP_CREATED);
    }
    /**
     * @Route("/patient/{id_patient}/disease/{id_disease}", name="deletePatientDisease", methods={"DELETE"})
     */
    public function delete($id_patient,$id_disease):JsonResponse
    {
        $patientDisease= $this->patientDiseaseRepository->findOneBySomeField($id_patient,$id_disease);
        if($patientDisease){
            $this->patientDiseaseRepository->removePatientDisease($patientDisease);
        }

        return new JsonResponse(['status'=> 'PatientDisease DELETED'], Response::HTTP_OK);
    }

    /**
     * @Route("/patientdisease", name="getAllPatientDisease", methods={"GET"})
     */
    public function  getAll():JsonResponse{
        $relationsPatientDisease=$this->patientDiseaseRepository->findAll();
        $data=Array();
        foreach ($relationsPatientDisease as $patientDisease){
            $data[]=[
                'id'=>$patientDisease->getId(),
                'id_patient'=>$patientDisease->getIdPatient()->getId(),
                'id_disease'=> $patientDisease -> getIdDisease()->getId(),

            ];
        }
        return new JsonResponse($data,Response::HTTP_OK);
    }

    /**
     * @Route("/patientdisease/{id}", name="getOnePatientDisease", methods={"GET"})
     */
    public function  get($id):JsonResponse{
        $patientDisease=$this->patientDiseaseRepository->findOneBy(['id' => $id]);

        if ($patientDisease){
            $data=[
                'id'=>$patientDisease->getId(),
                'id_patient'=>$patientDisease->getIdPatient()->getId(),
                'id_disease'=> $patientDisease -> getIdDisease()->getId(),
            ];

            return new JsonResponse($data,Response::HTTP_OK);
        }
        else{
            return new JsonResponse(['status'=>'Relacion patient-disease no encontrada'],Response::HTTP_NOT_FOUND);
        }

    }
    /**
     * @Route("/patient/disease/{id}", name="getOnePatientDiseaseById", methods={"GET"})
     */
    public function findDisease($id)
    {
        $patientDiseases = $this->patientDiseaseRepository->findManyBySomeField($id);
        if (!$patientDiseases) {
            //throw  new NotFoundHttpException("No existe un usuario con ese username");
            return new JsonResponse(null,Response::HTTP_OK);
        }
        $data=Array();
        foreach ($patientDiseases as $patientDisease){
            $data[]=[
                'id'=> $patientDisease -> getIdDisease()->getId(),
                'description'=> $patientDisease -> getIdDisease()->getDescription(),
            ];
        }

        return new JsonResponse($data,Response::HTTP_OK);


    }
    /**
     * @Route("/patient/disease/{id_patient}/{id_disease}", name="getOnePatientDiseaseByIds", methods={"GET"})
     */
    public function findPatientDisease($id_patient,$id_disease)
    {
        $patientDisease = $this->patientDiseaseRepository->findOneBySomeField($id_patient,$id_disease);
        if (!$patientDisease) {
            //throw  new NotFoundHttpException("No existe un usuario con ese username");
            return new JsonResponse(null,Response::HTTP_OK);
        }
        $data=Array(
            'id'=> $patientDisease -> getIdDisease()->getId(),
            'description'=> $patientDisease -> getIdDisease()->getDescription(),

        );
        return new JsonResponse($data,Response::HTTP_OK);
    }

}
