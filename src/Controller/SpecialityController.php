<?php

namespace App\Controller;

use App\Repository\DoctorRepository;
use App\Repository\ServiceRepository;
use App\Repository\SpecialityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SpecialityController
 * @package App\Controller*
 *

 */


class SpecialityController
{
    //constructor
    private $specialityRepository;
    public function __construct(SpecialityRepository $specialityRepository){

        $this->specialityRepository=$specialityRepository;
    }

    /**
     * @Route("/speciality", name="getAllSpecialities", methods={"GET"})
     */
    public function  getAll():JsonResponse{
        $specialities=$this->specialityRepository->findAll();
        $data=Array();
        foreach ($specialities as $speciality){
            $data[]=[
                'id'=>$speciality->getId(),
                'description'=>$speciality->getDescription(),

            ];
        }
        return new JsonResponse($data,Response::HTTP_OK);

    }
    /**
     * @Route("/speciality/{id}", name="getOneSpeciality", methods={"GET"})
     */
    public function showAction($id)
    {
        $speciality = $this->specialityRepository->find($id);
        if (!$speciality) {
            throw  new NotFoundHttpException("No existe un paciente con ese id");
        }
        $data=Array(
            'id'=>$speciality->getId(),
            'description'=>$speciality->getDescription(),

        );

        return new JsonResponse($data,Response::HTTP_OK);


    }
    /**
     * @Route("/speciality/canalize/{id}", name="getAllSpecialitiesExceptOne", methods={"GET"})
     */
    public function  getAllSpecialitiesExceptOne($id):JsonResponse{
        $specialities=$this->specialityRepository->findByExampleField($id);
        $data=Array();
        foreach ($specialities as $speciality){
            $data[]=[
                'id'=>$speciality->getId(),
                'description'=>$speciality->getDescription(),

            ];
        }
        return new JsonResponse($data,Response::HTTP_OK);

    }

}
