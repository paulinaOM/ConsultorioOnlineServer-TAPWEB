<?php

namespace App\Controller;

use App\Repository\PatientAllergyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class PatientAllergyController
{
    //constructor
    private $patientAllergyRepository;
    public function __construct(PatientAllergyRepository $patientAllergyRepository){
        $this->patientAllergyRepository=$patientAllergyRepository;
    }

    /**
     * @Route("/patientallergy", name="patientAllergy", methods={"POST"})
     */
    public function add(Request $request): JsonResponse
    {
        $data=json_decode($request->getContent(),true);

        $idPatient=$data['idPatient'];
        $idAllergy=$data['idAllergy'];

        if(empty($idPatient)||empty($idAllergy)){
            throw  new NotFoundHttpException("Se esperaban parámetros");
        }
        $this->patientAllergyRepository->savePatientAllergy($idPatient,$idAllergy);
        return new JsonResponse(['status'=>'Relacion patient-allergy creada'],Response::HTTP_CREATED);
    }

    /**
     * @Route("/patientallergy", name="getAllPatientAllergy", methods={"GET"})
     */
    public function  getAll():JsonResponse{
        $relationsPatientAllergy=$this->patientAllergyRepository->findAll();
        $data=Array();
        foreach ($relationsPatientAllergy as $patientAllergy){
            $data[]=[
                'id'=>$patientAllergy->getId(),
                'id_patient'=>$patientAllergy->getIdPatient()->getId(),
                'id_allergy'=> $patientAllergy -> getIdAllergy()->getId(),

            ];
        }
        return new JsonResponse($data,Response::HTTP_OK);
    }

    /**
     * @Route("/patientallergy/{id}", name="getOnePatientAllergy", methods={"GET"})
     */
    public function  get($id):JsonResponse{
        $patientAllergy=$this->patientAllergyRepository->findOneBy(['id' => $id]);

        if ($patientAllergy){
            $data=[
                'id'=>$patientAllergy->getId(),
                'id_patient'=>$patientAllergy->getIdPatient()->getId(),
                'id_allergy'=> $patientAllergy -> getIdAllergy()->getId(),
            ];

            return new JsonResponse($data,Response::HTTP_OK);
        }
        else{
            return new JsonResponse(['status'=>'Relacion patient-allergy no encontrada'],Response::HTTP_NOT_FOUND);
        }

    }
    /**
     * @Route("/patient/allergy/{id}", name="getPatientAllergyById", methods={"GET"})
     */
    public function findAllergy($id)
    {
        $patientAllergies = $this->patientAllergyRepository->findManyBySomeField($id);
        if (!$patientAllergies) {
            //throw  new NotFoundHttpException("No existe un usuario con ese username");
            return new JsonResponse(null,Response::HTTP_OK);
        }
        $data=Array();
        foreach ($patientAllergies as $patientAllergy){
            $data[]=[
                'id'=> $patientAllergy -> getIdAllergy()->getId(),
                'description'=> $patientAllergy -> getIdAllergy()->getDescription(),
            ];
        }

        return new JsonResponse($data,Response::HTTP_OK);
    }
    /**
     * @Route("/patient/{id_patient}/allergy/{id_allergy}", name="deletePatientAllergy", methods={"DELETE"})
     */
    public function delete($id_patient,$id_allergy):JsonResponse
    {
        $patientAllergy= $this->patientAllergyRepository->findOneBySomeField($id_patient,$id_allergy);
        if ($patientAllergy){
            $this->patientAllergyRepository->removePatientAllergy($patientAllergy);
        }
        return new JsonResponse(['status'=> 'PatientAllergy DELETED'], Response::HTTP_OK);
    }

    /**
     * @Route("/patient/allergy/{id_patient}/{id_allergy}", name="getOnePatientAllergyByIds", methods={"GET"})
     */
    public function findPatientAllergy($id_patient,$id_allergy)
    {
        $patientAllergy = $this->patientAllergyRepository->findOneBySomeField($id_patient,$id_allergy);
        if (!$patientAllergy) {
            //throw  new NotFoundHttpException("No existe un usuario con ese username");
            return new JsonResponse(null,Response::HTTP_OK);
        }
        $data=Array(
            'id'=> $patientAllergy -> getIdAllergy()->getId(),
            'description'=> $patientAllergy -> getIdAllergy()->getDescription(),

        );
        return new JsonResponse($data,Response::HTTP_OK);
    }

}
