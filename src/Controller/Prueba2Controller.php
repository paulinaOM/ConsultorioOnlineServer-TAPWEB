<?php

namespace App\Controller;

use App\Repository\DoctorRepository;
use App\Repository\Prueba2Repository;
use App\Repository\ServiceRepository;
use App\Repository\SpecialityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class Prueba2Controller
 * @package App\Controller*
 *

 */


class Prueba2Controller
{
    //constructor
    private $prueba2Repository;
    public function __construct(Prueba2Repository $prueba2Repository){

        $this->prueba2Repository=$prueba2Repository;
    }
    /**
     * @Route("/prueba2", name="prueba2", methods={"POST"})
     */
    public function add(Request $request): JsonResponse
    {
        $data=json_decode($request->getContent(),true);
        $foraneo_id=$data['foraneo_id'];
        $campo1=$data['campo1'];


        if(empty($foraneo_id)||empty($campo1)){
            throw  new NotFoundHttpException("Se esperaban parámetros");
        }
        $this->prueba2Repository->savePrueba2($foraneo_id,$campo1);
        return new JsonResponse(['status'=>'Prueba2 creado'],Response::HTTP_CREATED);
    }

    /**
     * @Route("/prueba2", name="getAllPrueba2", methods={"GET"})
     */
    public function  getAll():JsonResponse{
        $prueba2s=$this->prueba2Repository->findAll();
        $data=Array();
        foreach ($prueba2s as $prueba2){
            $data[]=[
                'id'=>$prueba2->getId(),
                'foraneo_id'=>$prueba2->getForaneo(),
                'campo1'=>$prueba2->getCampo1(),

            ];
        }
        return new JsonResponse($data,Response::HTTP_OK);

    }
}
