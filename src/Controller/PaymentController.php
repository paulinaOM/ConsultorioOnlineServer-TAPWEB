<?php

namespace App\Controller;

use App\Repository\DoctorRepository;
use App\Repository\PaymentRepository;
use App\Repository\ServiceRepository;
use App\Repository\SpecialityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PaymentController
 * @package App\Controller*
 *

 */


class PaymentController
{
    //constructor
    private $paymentRepository;
    public function __construct(PaymentRepository $paymentRepository){

        $this->paymentRepository=$paymentRepository;
    }

    /**
     * @Route("/payment", name="getAllPayment", methods={"GET"})
     */
    public function  getAll():JsonResponse{
        $payments=$this->paymentRepository->findAll();
        $data=Array();
        foreach ($payments as $payment){
            $data[]=[
                'id'=>$payment->getId(),
                'description'=>$payment->getDescription(),

            ];
        }
        return new JsonResponse($data,Response::HTTP_OK);

    }
    /**
     * @Route("/payment/{id}", name="getOnePayment", methods={"GET"})
     */
    public function showAction($id)
    {
        $payment = $this->paymentRepository->find($id);
        if (!$payment) {
            throw  new NotFoundHttpException("No existe un tipo de pago con ese id");
        }
        $data=Array(
            'id'=>$payment->getId(),
            'description'=>$payment->getDescription(),

        );

        return new JsonResponse($data,Response::HTTP_OK);


    }
}
