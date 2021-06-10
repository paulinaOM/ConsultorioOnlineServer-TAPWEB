<?php

namespace App\Controller;

use App\Repository\DoctorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DoctorController
 * @package App\Controller*
 *

 */


class DoctorController
{
    //constructor
    private $doctorRepository;
    public function __construct(DoctorRepository $doctorRepository){
        $this->doctorRepository=$doctorRepository;
    }
    /**
     * @Route("/doctor", name="doctor", methods={"POST"})
     */
    public function add(Request $request): JsonResponse
    {
        $data=json_decode($request->getContent(),true);
        $name=$data['name'];
        $lastname=$data['lastname'];
        $mobile_phone=$data['mobile_phone'];
        $email=$data['email'];
        $address=$data['address'];
        $city=$data['city'];
        $state=$data['state'];
        $country=$data['country'];
        $license=$data['license'];
        $id_speciality=$data['id_speciality'];
        $id_user=$data['id_user'];


        if(empty($name)||empty($lastname)||empty($address)||empty($city)||empty($state)||empty($country)
            ||empty($license)||empty($mobile_phone)||empty($email)||empty($id_user)||empty($id_speciality)){
            throw  new NotFoundHttpException("Se esperaban parámetros");
        }
        $this->doctorRepository->saveDoctor($name,$lastname,$address,$city,$state,$country,$license
            ,$mobile_phone,$email,$id_user,$id_speciality);
        return new JsonResponse(['status'=>'Doctor creado'],Response::HTTP_CREATED);
    }
    /**
     * @Route("/doctor", name="getAllDoctors", methods={"GET"})
     */
    public function  getAll():JsonResponse{
        $doctors=$this->doctorRepository->findAll();
        $data=Array();
        foreach ($doctors as $doctor){
            $data[]=[
                'id'=>$doctor->getId(),
                'name'=>$doctor->getName(),
                'lastname'=>$doctor->getLastname(),
                'mobile_phone'=>$doctor->getMobilePhone(),
                'email'=>$doctor->getEmail(),
                'address'=>$doctor->getAddress(),
                'city'=>$doctor->getCity(),
                'state'=>$doctor->getState(),
                'country'=>$doctor->getCountry(),
                'license'=>$doctor->getLicense(),
                'id_speciality'=>$doctor->getIdSpeciality()->getId(),
                'speciality' => $doctor->getIdSpeciality()->getDescription(),
                'id_user'=>$doctor->getIdUser()->getId(),

            ];
        }
        return new JsonResponse($data,Response::HTTP_OK);

    }
    /**
     * @Route("/doctor/{id}", name="getOneDoctor", methods={"GET"})
     */
    public function showAction($id)
    {
        $doctor = $this->doctorRepository->find($id);
        if (!$doctor) {
            throw  new NotFoundHttpException("No existe un paciente con ese id");
        }
        $data=Array(
            'id'=>$doctor->getId(),
            'name'=>$doctor->getName(),
            'lastname'=>$doctor->getLastname(),
            'mobile_phone'=>$doctor->getMobilePhone(),
            'email'=>$doctor->getEmail(),
            'address'=>$doctor->getAddress(),
            'city'=>$doctor->getCity(),
            'state'=>$doctor->getState(),
            'country'=>$doctor->getCountry(),
            'license'=>$doctor->getLicense(),
            'id_speciality'=>$doctor->getIdSpeciality()->getId(),
            'speciality' => $doctor->getIdSpeciality()->getDescription(),
            'id_user'=>$doctor->getIdUser()->getId(),

        );

        return new JsonResponse($data,Response::HTTP_OK);


    }
    /**
     * @Route("/doctor/speciality/{id}", name="getDoctorSpeciality", methods={"GET"})
     */
    public function  getDoctorsBySpeciality($id):JsonResponse{
        $doctors=$this->doctorRepository->findBySpeciality($id);
        $data=Array();
        foreach ($doctors as $doctor){
            $data[]=[
                'id'=>$doctor->getId(),
                'name'=>$doctor->getName(),
                'lastname'=>$doctor->getLastname(),
                'mobile_phone'=>$doctor->getMobilePhone(),
                'email'=>$doctor->getEmail(),
                'address'=>$doctor->getAddress(),
                'city'=>$doctor->getCity(),
                'state'=>$doctor->getState(),
                'country'=>$doctor->getCountry(),
                'license'=>$doctor->getLicense(),
                'id_speciality'=>$doctor->getIdSpeciality()->getId(),
                'speciality' => $doctor->getIdSpeciality()->getDescription(),
                'id_user'=>$doctor->getIdUser()->getId(),

            ];
        }
        $response = new JsonResponse($data, Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');

        return $response;

    }
    /**
     * @Route("/doctor/user/{id}", name="getDoctorByUserId", methods={"GET"})
     */
    public function findDoctorByUserId($id)
    {
        $doctor = $this->doctorRepository->getDoctor($id);
        if (!$doctor) {
            //throw  new NotFoundHttpException("No existe un usuario con ese username");

            return new JsonResponse(null,Response::HTTP_OK);
        }

        $data=Array(
            'id'=>$doctor->getId(),
            'name'=>$doctor->getName(),
            'lastname'=>$doctor->getLastname(),
            'mobile_phone'=>$doctor->getMobilePhone(),
            'email'=>$doctor->getEmail(),
            'address'=>$doctor->getAddress(),
            'city'=>$doctor->getCity(),
            'state'=>$doctor->getState(),
            'country'=>$doctor->getCountry(),
            'license'=>$doctor->getLicense(),
            'id_speciality'=>$doctor->getIdSpeciality()->getId(),
            'speciality' => $doctor->getIdSpeciality()->getDescription(),
            'id_user'=>$doctor->getIdUser()->getId(),

        );

        return new JsonResponse($data,Response::HTTP_OK);


    }

}
