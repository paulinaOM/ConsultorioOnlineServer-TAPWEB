<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use App\Repository\PatientRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;



/**
 * Class PatientController
 * @package App\Controller*
 *

 */


class PatientController
{
    //constructor
    private $patientRepository;
    public function __construct(PatientRepository $patientRepository){
        $this->patientRepository=$patientRepository;
    }

    /**
     * @Route("/patient", name="patient", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function add(Request $request): JsonResponse
    {
        $data=json_decode($request->getContent(),true);
        $name=$data['name'];
        $lastname=$data['lastname'];
        $address=$data['address'];
        $city=$data['city'];
        $state=$data['state'];
        $country=$data['country'];
        $birthdate=$data['birthdate'];
        $phone=$data['phone'];
        $email=$data['email'];
        $id_user=$data['id_user'];
        $latitud=$data['latitud'];
        $longitud=$data['longitud'];
        $status_covid=$data['status_covid'];

        if(empty($name)||empty($lastname)||empty($address)||empty($city)||empty($state)||empty($country)
            ||empty($birthdate)||empty($phone)||empty($email)||empty($id_user)||empty($status_covid)||empty($longitud)||empty($latitud)){
            throw  new NotFoundHttpException("Se esperaban parámetros");
        }

        $this->patientRepository->savePatient($name,$lastname,$address,$city,$state,$country,$birthdate
            ,$phone,$email,$id_user,$latitud,$longitud,$status_covid);
        return new JsonResponse(['status'=>'Paciente creado'],Response::HTTP_CREATED);
    }
    /**
     * @Route("/patient", name="getAllPatients", methods={"GET"})
     */
    public function  getAll():JsonResponse{
        $patients=$this->patientRepository->findAll();
        $data=Array();
        foreach ($patients as $patient){
            $data[]=[
                'id'=>$patient->getId(),
                'name'=>$patient->getName(),
                'lastname'=>$patient->getLastname(),
                'address'=>$patient->getAddress(),
                'city'=>$patient->getCity(),
                'state'=>$patient->getState(),
                'country'=>$patient->getCountry(),
                'birthdate'=>$patient->getBirthdate(),
                'phone'=>$patient->getPhone(),
                'email'=>$patient->getEmail(),
                'id_user'=>$patient->getIdUser()->getId(),
                'status_covid'=>$patient->getStatusCovid(),

            ];
        }
        return new JsonResponse($data,Response::HTTP_OK);

    }
    /**
     * @Route("/patient/{id}", name="getOnePatient", methods={"GET"})
     */
    public function showAction($id)
    {
        $patient = $this->patientRepository->find($id);
        if (!$patient) {
            throw  new NotFoundHttpException("No existe un paciente con ese id");
        }
        $today= new \DateTime();
        $age=$today->diff($patient->getBirthdate())->format("%y");
        $data=Array(
            'id'=>$patient->getId(),
            'name'=>$patient->getName(),
            'lastname'=>$patient->getLastname(),
            'address'=>$patient->getAddress(),
            'city'=>$patient->getCity(),
            'state'=>$patient->getState(),
            'country'=>$patient->getCountry(),
            'birthdate'=>$patient->getBirthdate(),
            'phone'=>$patient->getPhone(),
            'email'=>$patient->getEmail(),
            'id_user'=>$patient->getIdUser()->getId(),
            'status_covid'=>$patient->getStatusCovid(),
            'age'=>$age

        );

        return new JsonResponse($data,Response::HTTP_OK);

    }
    /**
     * @Route("/patient/user/{id}", name="getPatientByUserId", methods={"GET"})
     */
    public function findPatientByUserId($id)
    {
        $patient = $this->patientRepository->getPatient($id);
        if (!$patient) {
            //throw  new NotFoundHttpException("No existe un usuario con ese username");

            return new JsonResponse(null,Response::HTTP_OK);
        }

         $data=Array(
            'id'=>$patient->getId(),
            'name'=>$patient->getName(),
            'lastname'=>$patient->getLastname(),
            'address'=>$patient->getAddress(),
            'city'=>$patient->getCity(),
            'state'=>$patient->getState(),
            'country'=>$patient->getCountry(),
            'birthdate'=>$patient->getBirthdate(),
            'phone'=>$patient->getPhone(),
            'email'=>$patient->getEmail(),
            'id_user'=>$patient->getIdUser()->getId(),
            'status_covid'=>$patient->getStatusCovid(),

        );

        return new JsonResponse($data,Response::HTTP_OK);


    }
    /**
     * @Route("/patient/updatestatus/{id}/{status}", name="updateStatusCovid", methods={"PUT"})
     */
    public function updateStatus($id,$status):JsonResponse
    {
        $patient = $this->patientRepository->findOneBy(['id'=>$id]);

        empty($status)? true : $patient->setStatusCovid($status);

        $this->patientRepository->updateStatus($patient);

        return new JsonResponse(['status'=> 'Status_covid updated'], Response::HTTP_OK);
    }
    /**
     * @Route("/patient/covid/{state}", name="getPatientCovid", methods={"GET"})
     */
    public function getCovid($state):JsonResponse
    {
        $country ="Mexico";
        $aux = $this->patientRepository->findByState($state,$country);

        $cities = Array();
        foreach ($aux as $city){
            $cities[]=$city['city'];
        }

        $data = Array();
        foreach ($cities as $city) {
            $status = "confirmado";
            $confirmedCases = $this->patientRepository->countCovid($state,$city, $status);
            $status="sospechoso";
            $suspectCases = $this->patientRepository->countCovid($state, $city, $status);
            $status="negativo";
            $negativeCases = $this->patientRepository->countCovid($state, $city, $status);
            $data[]=[
                'city'=>$city,
                'confirmed' => $confirmedCases,
                'suspect' => $suspectCases,
                'negative' => $negativeCases
            ];
        }
        return new JsonResponse($data,Response::HTTP_OK);
    }

    /**
     * @Route("/covid/world", name="getLocationCovid", methods={"GET"})
     */
    public function getLocationCovid():JsonResponse
    {
        $auxiliar = $this->patientRepository->findBy(['status_covid'=>'confirmado']);

        $data = Array();
        foreach ($auxiliar as $aux) {
            $data[]=[
                'position'=>[
                    'lat'=>$aux->getLatitud(),
                    'lng'=>$aux->getLongitud()
                ]
            ];
        }
        return new JsonResponse($data,Response::HTTP_OK);
    }

}
