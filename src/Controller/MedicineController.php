<?php

namespace App\Controller;

use App\Repository\DoctorRepository;
use App\Repository\MedicineRepository;
use App\Repository\ServiceRepository;
use App\Repository\SpecialityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MedicineController
 * @package App\Controller*
 *

 */


class MedicineController
{
    //constructor
    private $medicineRepository;
    public function __construct(MedicineRepository $medicineRepository){

        $this->medicineRepository=$medicineRepository;
    }

    /**
     * @Route("/medicine", name="getAllMedicine", methods={"GET"})
     */
    public function  getAll():JsonResponse{
        $medicines=$this->medicineRepository->findAll();
        $data=Array();
        foreach ($medicines as $medicine){
            $data[]=[
                'id'=>$medicine->getId(),
                'name'=>$medicine->getName(),
                'type'=>$medicine->getType(),
                'substance'=>$medicine->getSubstance(),
                'laboratory'=>$medicine->getLaboratory(),
                'cost'=>$medicine->getCost(),

            ];
        }
        return new JsonResponse($data,Response::HTTP_OK);

    }
    /**
     * @Route("/medicine/{id}", name="getOneMedicine", methods={"GET"})
     */
    public function showAction($id)
    {
        $medicine = $this->medicineRepository->find($id);
        if (!$medicine) {
            throw  new NotFoundHttpException("No existe un medicamento con ese id");
        }
        $data=Array(
            'id'=>$medicine->getId(),
            'name'=>$medicine->getName(),
            'type'=>$medicine->getType(),
            'substance'=>$medicine->getSubstance(),
            'laboratory'=>$medicine->getLaboratory(),
            'cost'=>$medicine->getCost(),

        );

        return new JsonResponse($data,Response::HTTP_OK);


    }
}
