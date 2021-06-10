<?php

namespace App\Controller;

use App\Repository\DoctorRepository;
use App\Repository\MedicalConsultationRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class MedicalConsultationController
{
    //constructor
    private $medicalConsultationRepository,$doctorRepository;
    public function __construct(MedicalConsultationRepository $medicalConsultationRepository,DoctorRepository $doctorRepository){
        $this->medicalConsultationRepository=$medicalConsultationRepository;
        $this->doctorRepository=$doctorRepository;
    }

    /**
     * @Route("/medicalconsultation", name="medicalconsultation", methods={"POST"})
     */
    public function add(Request $request): JsonResponse
    {
        $data=json_decode($request->getContent(),true);

        $idPatient=$data['id_patient'];
        $symptom=$data['symptom'];
        $atentionStatus =$data['atention_status'];
        $consultationDate =$data['consultation_date'];
        $idDoctor =$data['id_doctor'];

        if(empty($idPatient)||empty($symptom)||empty($atentionStatus)|| empty($consultationDate)||empty($idDoctor)){
            throw  new NotFoundHttpException("Se esperaban parámetros: ".$idPatient." ".$symptom." ".$atentionStatus." ".$consultationDate." ".$idDoctor);
        }
        $this->medicalConsultationRepository->saveMedicalConsultation($idPatient,$symptom,$atentionStatus,$consultationDate,$idDoctor);
        return new JsonResponse(['status'=>'Consulta creada'],Response::HTTP_CREATED);
    }

    /**
     * @Route("/medicalconsultation", name="getAllMedicalConsultations", methods={"GET"})
     */
    public function  getAll():JsonResponse{
        $consultations=$this->medicalConsultationRepository->findAll();
        $data=Array();
        foreach ($consultations as $medicalConsultation){
            $data[]=[
                'id_patient'=>$medicalConsultation->getIdPatient()->getId(),
                'symptom'=>$medicalConsultation->getSymptom(),
                'atention_status' => $medicalConsultation->getAtentionStatus(),
                'consultation_date' => $medicalConsultation->getConsultationDate(),
                'id_doctor' => $medicalConsultation->getIdDoctor()->getId(),
            ];
        }
        return new JsonResponse($data,Response::HTTP_OK);
    }

    /**
     * @Route("/medicalconsultation/{id}", name="getOneMedicalConsultation", methods={"GET"})
     */
    public function  get($id):JsonResponse{
        $medicalConsultation=$this->medicalConsultationRepository->findOneBy(['id' => $id]);

        if ($medicalConsultation){
            $data=[
                'id_patient'=>$medicalConsultation->getIdPatient()->getId(),
                'doctor_name' => $medicalConsultation->getIdDoctor()->getName()." ".$medicalConsultation->getIdDoctor()->getLastname(),
                'patient_name' => $medicalConsultation->getIdPatient()->getName()." ".$medicalConsultation->getIdPatient()->getLastname(),
                'symptom'=>$medicalConsultation->getSymptom(),
                'atention_status' => $medicalConsultation->getAtentionStatus(),
                'consultation_date' => $medicalConsultation->getConsultationDate(),
                'id_doctor' => $medicalConsultation->getIdDoctor()->getId(),

            ];

            return new JsonResponse($data,Response::HTTP_OK);
        }
        else{
            return new JsonResponse(['status'=>'Consulta no encontrada'],Response::HTTP_NOT_FOUND);
        }

    }
    /**
     * @Route("/consultation/last", name="getLastMedicalConsultation", methods={"GET"})
     */
    public function  getLast():JsonResponse{
        $lastIdConsultation=$this->medicalConsultationRepository->findLast();
        return new JsonResponse($lastIdConsultation,Response::HTTP_OK);
    }

    /**
     * @Route("/medicalconsultation/patient/{id}", name="getMedicalConsultationPatient", methods={"GET"})
     */
    public function  getPatientConsultation($id):JsonResponse{
        $consultations=$this->medicalConsultationRepository->findBy(['patient' => $id]);

        $data=Array();
        foreach ($consultations as $medicalConsultation){
            $data[]=[
                'id'=>$medicalConsultation->getId(),
                'id_patient'=>$medicalConsultation->getIdPatient()->getId(),
                'symptom'=>$medicalConsultation->getSymptom(),
                'atention_status' => ($medicalConsultation->getAtentionStatus()==1)? 'Pendiente':'Atendido',
                'consultation_date' => $medicalConsultation->getConsultationDate()->format('Y-m-d'),
                'id_doctor' => $medicalConsultation->getIdDoctor()->getId(),
                'doctor_name' => $medicalConsultation->getIdDoctor()->getName()." ".$medicalConsultation->getIdDoctor()->getLastname(),
                'speciality' => $medicalConsultation->getIdDoctor()->getIdSpeciality()->getDescription(),
            ];
        }
        return new JsonResponse($data,Response::HTTP_OK);
    }
    /**
     * @Route("/medicalconsultation/doctor/{id}", name="getMedicalConsultationByDoctor", methods={"GET"})
     */
    public function  getDoctorConsultation($id):JsonResponse{
        $consultations=$this->medicalConsultationRepository->findBy(['doctor' => $id]);

        $data=Array();
        foreach ($consultations as $medicalConsultation){
            if($medicalConsultation->getAtentionStatus()==2){
                $data[]=[
                    'id'=>$medicalConsultation->getId(),
                    'id_patient'=>$medicalConsultation->getIdPatient()->getId(),
                    'symptom'=>$medicalConsultation->getSymptom(),
                    'patient_name'=>$medicalConsultation->getIdPatient()->getName().$medicalConsultation->getIdPatient()->getLastname(),
                    'atention_status' => ($medicalConsultation->getAtentionStatus()==1)? 'Pendiente':'Atendido',
                    'consultation_date' => $medicalConsultation->getConsultationDate()->format('Y-m-d'),
                    'id_doctor' => $medicalConsultation->getIdDoctor()->getId(),
                    'doctor_name' => $medicalConsultation->getIdDoctor()->getName()." ".$medicalConsultation->getIdDoctor()->getLastname(),
                    'speciality' => $medicalConsultation->getIdDoctor()->getIdSpeciality()->getDescription(),
                ];
            }

        }
        return new JsonResponse($data,Response::HTTP_OK);
    }
    /**
     * @Route("/consultation/speciality/{id}", name="getConsultationsBySpeciality", methods={"GET"})
     */
    public function findConsultations($id)
    {
        $consultations = $this->medicalConsultationRepository->findManyBySomeField($id);
        if (!$consultations) {
            //throw  new NotFoundHttpException("No existe un usuario con ese username");
            return new JsonResponse(null,Response::HTTP_OK);
        }
        $data=Array();
        foreach ($consultations as $medicalConsultation){
            $data[]=[
                'id'=>$medicalConsultation->getId(),
                'id_patient'=>$medicalConsultation->getIdPatient()->getId(),
                'patient_name'=>$medicalConsultation->getIdPatient()->getName().$medicalConsultation->getIdPatient()->getLastname(),
                'symptom'=>$medicalConsultation->getSymptom(),
                'atention_status' => ($medicalConsultation->getAtentionStatus()==1)? 'Pendiente':'Atendido',
                'consultation_date' => $medicalConsultation->getConsultationDate()->format('Y-m-d'),
                'id_doctor' => $medicalConsultation->getIdDoctor()->getId(),
                'doctor_name' => $medicalConsultation->getIdDoctor()->getName()." ".$medicalConsultation->getIdDoctor()->getLastname(),
                'id_speciality' => $medicalConsultation->getIdDoctor()->getIdSpeciality()->getID(),

            ];
        }

        return new JsonResponse($data,Response::HTTP_OK);


    }

    /**
     * @Route("/medicalconsultation/update/{id}/{id_doctor}", name="updateMedicalConsultation", methods={"POST"})
     */
    public function update($id,$id_doctor):JsonResponse
    {
        $medicalConsultation= $this->medicalConsultationRepository->findOneBy(['id'=>$id]);

        $doctor = $this->doctorRepository->findOneBy(['id'=>$id_doctor]);
        empty($id_doctor)? true : $medicalConsultation->setIdDoctor($doctor);

        $this->medicalConsultationRepository->updateConsultation($medicalConsultation);

        return new JsonResponse(['status'=> 'MedicalConsultation updated'], Response::HTTP_OK);
    }
    /**
     * @Route("/medicalconsultation/updatestatus/{id}/{status}", name="updateStatus", methods={"PUT"})
     */
    public function updateStatus($id,$status):JsonResponse
    {
        $medicalConsultation = $this->medicalConsultationRepository->findOneBy(['id'=>$id]);

        empty($status)? true : $medicalConsultation->setAtentionStatus($status);

        $this->medicalConsultationRepository->updateStatus($medicalConsultation);

        return new JsonResponse(['status'=> 'Atention_status updated'], Response::HTTP_OK);
    }



}
