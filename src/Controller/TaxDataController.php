<?php

namespace App\Controller;

use App\Repository\TaxDataRepository;
use App\Repository\PaymentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;


class TaxDataController
{
    //constructor
    private $taxDataRepository,$paymentRepository;
    public function __construct(TaxDataRepository $taxDataRepository,PaymentRepository $paymentRepository){
        $this->taxDataRepository=$taxDataRepository;
        //$this->manager=$manager;
        $this->paymentRepository=$paymentRepository;
    }
    /**
     * @Route("/taxdata", name="taxdata", methods={"POST"})
     */
    public function add(Request $request): JsonResponse
    {
        $data=json_decode($request->getContent(),true);
        $idPatient=$data['idPatient'];
        $billingAddress=$data['billingAddress'];
        $shippingDate =$data['shippingDate'];
        $idPayment =$data['idPayment'];

        if(empty($idPatient)||empty($billingAddress)||empty($shippingDate)||empty($idPayment)){
            throw  new NotFoundHttpException("Se esperaban parámetros");
        }
        $this->taxDataRepository->saveTaxdata($idPatient,$billingAddress,$shippingDate,$idPayment);
        return new JsonResponse(['status'=>'Datos de facturación creados'],Response::HTTP_CREATED);
    }

    /**
     * @Route("/taxdata", name="getAllTaxes", methods={"GET"})
     */
    public function  getAll():JsonResponse{
        $taxes=$this->taxDataRepository->findAll();
        $data=Array();
        foreach ($taxes as $taxData){
            $data[]=[
                'id'=>$taxData->getId(),
                'id_patient'=>$taxData->getIdPatient()->getId(),
                'billing_address'=> $taxData -> getBillingAddress(),
                'shipping_date' => $taxData -> getShippingDate(),
                'id_payment' => $taxData -> getIdPayment()->getId(),
            ];
        }
        return new JsonResponse($data,Response::HTTP_OK);
    }

    /**
     * @Route("/taxdata/{id}", name="getOneTaxdata", methods={"GET"})
     */
    public function  get($id):JsonResponse{
        $taxData=$this->taxDataRepository->findOneBy(['id' => $id]);

        if ($taxData){
            $data=[
                'id'=>$taxData->getId(),
                'id_patient'=>$taxData->getIdPatient()->getId(),
                'billing_address'=> $taxData -> getBillingAddress(),
                'shipping_date' => $taxData -> getShippingDate(),
                'id_payment' => $taxData -> getIdPayment()->getId(),
            ];

            return new JsonResponse($data,Response::HTTP_OK);
        }
        else{
            return new JsonResponse(['status'=>'Factura no encontrada'],Response::HTTP_NOT_FOUND);
        }

    }
    /**
     * @Route("/taxdata/patient/{id}", name="getOneTaxData", methods={"GET"})
     */
    public function findTaxData($id)
    {
        $taxData = $this->taxDataRepository->findOneBySomeField($id);
        if (!$taxData) {
            //throw  new NotFoundHttpException("No existe un usuario con ese username");
            return new JsonResponse(null,Response::HTTP_OK);
        }
        $data=Array(
            'id'=>$taxData->getId(),
            'id_patient'=>$taxData->getIdPatient()->getId(),
            'billing_address'=> $taxData -> getBillingAddress(),
            'shipping_date' => $taxData -> getShippingDate(),
            'id_payment' => $taxData -> getIdPayment()->getId(),

        );

        return new JsonResponse($data,Response::HTTP_OK);


    }
    /**
     * @Route("/taxdata/update", name="updateTaxData", methods={"POST"})
     */
    public function update(Request $request):JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $id_patient=$data['id_patient'];
        $id_payment =$data['id_payment'];
        $taxData = $this->taxDataRepository->findOneBySomeField($id_patient);

        empty($data['billing_address'])? true : $taxData->setBillingAddress($data['billing_address']);
        empty($data['shipping_date'])? true : $taxData->setShippingDate($data['shipping_date']);
        $payment = $this->paymentRepository->findOneBy(['id'=>$id_payment]);
        $taxData->setIdPayment($payment);

        $this->taxDataRepository->updateTaxData($taxData);

        return new JsonResponse(['status'=> 'TaxData updated'], Response::HTTP_OK);
    }
/*
    /**
     * @Route("/taxdata/update", name="taxdata", methods={"POST"})
     */
    /*public function updateAction(Request $request)
    {
        $data=json_decode($request->getContent(),true);

        $id_patient=$data['id_patient'];
        $billing=$data['billing_address'];
        $shipping =$data['shipping_date'];
        $id_payment =$data['id_payment'];

        $taxData = $this->taxDataRepository->findOneBySomeField($id_patient);
        if (!$taxData) {
            throw new NotFoundHttpException(
                'No register on taxdata table found for id '.$id_patient
            );
        };
        $taxData->setBillingAddress($billing);
        $taxData->setShippingDate($shipping);
        $payment = $this->paymentRepository->findOneBy(['id'=>$id_payment]);
        $taxData->setIdPayment($payment);

        $this->manager->flush();
        return new JsonResponse(['status'=>'Datos faturación acualizados'],Response::HTTP_CREATED);


    }*/
}
