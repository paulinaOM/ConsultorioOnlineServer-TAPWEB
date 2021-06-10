<?php

namespace App\Controller;

use App\Repository\BillRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\UrlHelper;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class BillController extends AbstractController
{
    //constructor
    private $billRepository;
    private $urlHelper;

    public function __construct(BillRepository $billRepository, UrlHelper $urlHelper){
        $this->billRepository=$billRepository;
        $this->urlHelper = $urlHelper;
    }

    /**
     * @Route("/bill", name="bill", methods={"POST"})
     */
    public function add(Request $request): JsonResponse
    {
        $dataFile = $request->get('file');

        if(!empty($dataFile)){
            $data = base64_decode($dataFile);
            // print_r($data);
            $filename=sprintf('%s.%s',uniqid("m_",true),"pdf");
            file_put_contents( $this->getParameter('bill_directory').$filename, $data );
            $idMedicalConsultation=$request->get('id_consultation');
        } else {
            echo "No Data Sent";
        }

        if(empty($idMedicalConsultation)||empty($filename)){
            throw  new NotFoundHttpException("Se esperaban parámetros");
        }
        $this->billRepository->saveBill($idMedicalConsultation,$filename);
        return new JsonResponse(['status'=>'Prescripcion creada'],Response::HTTP_CREATED);
    }

    /**
     * @Route("/bill", name="getAllBill", methods={"GET"})
     */
    public function  getAll():JsonResponse{
        $bills=$this->billRepository->findAll();
        $data=Array();
        foreach ($bills as $bill){
            $data[]=[
                'id'=>$bill->getId(),
                'id_consultation'=>$bill->getIdConsultation()->getId(),
                'consultation_date' => $bill->getIdConsultation()->getConsultationDate()->format('Y-m-d'),
                'speciality' => $bill->getIdConsultation()->getIdDoctor()->getIdSpeciality()->getDescription(),
                'doctor' => $bill->getIdConsultation()->getIdDoctor()->getName()." ".$bill->getIdConsultation()->getIdDoctor()->getLastname(),
                'filename'=> $bill -> getFilename(),
                'file' => $this->urlHelper->getAbsoluteUrl('/bills/'.$bill->getFilename())
            ];
        }
        return new JsonResponse($data,Response::HTTP_OK);
    }

    /**
     * @Route("/bill/{id}", name="getOneBill", methods={"GET"})
     */
    public function  getOneBill($id):JsonResponse{
        $bill=$this->billRepository->findOneBy(['id' => $id]);

        if ($bill){
            $data=[
                'id'=>$bill->getId(),
                'id_consultation'=>$bill->getIdConsultation()->getId(),
                'consultation_date' => $bill->getIdConsultation()->getConsultationDate()->format('Y-m-d'),
                'speciality' => $bill->getIdConsultation()->getIdDoctor()->getIdSpeciality()->getDescription(),
                'doctor' => $bill->getIdConsultation()->getIdDoctor()->getName()." ".$bill->getIdConsultation()->getIdDoctor()->getLastname(),
                'filename'=> $bill -> getFilename(),
                'file' => $this->urlHelper->getAbsoluteUrl('/bills/'.$bill->getFilename())
            ];

            return new JsonResponse($data,Response::HTTP_OK);
        }
        else{
            return new JsonResponse(['status'=>'bill no encontrada'],Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * @Route("/patient/{id}/bills", name="getBillPatient", methods={"GET"})
     */
    public function  getBillPatient($id):JsonResponse{
        $bills=$this->billRepository->getBillsByPatient($id);

        $data=Array();
        foreach ($bills as $bill){
            $data[]=[
                'id'=>$bill->getId(),
                'id_consultation'=>$bill->getIdConsultation()->getId(),
                'consultation_date' => $bill->getIdConsultation()->getConsultationDate()->format('Y-m-d'),
                'speciality' => $bill->getIdConsultation()->getIdDoctor()->getIdSpeciality()->getDescription(),
                'doctor' => $bill->getIdConsultation()->getIdDoctor()->getName()." ".$bill->getIdConsultation()->getIdDoctor()->getLastname(),
                'filename'=> $bill -> getFilename(),
                'file' => $this->urlHelper->getAbsoluteUrl('/bills/'.$bill->getFilename())
            ];
        }
        return new JsonResponse($data,Response::HTTP_OK);
    }
    /**
     * @Route("/doctor/{id}/bills", name="getBillByDoctor", methods={"GET"})
     */
    public function  getBillByDoctor($id):JsonResponse{
        $bills=$this->billRepository->getBillsByDoctor($id);

        $data=Array();
        foreach ($bills as $bill){
            $data[]=[
                'id'=>$bill->getId(),
                'id_consultation'=>$bill->getIdConsultation()->getId(),
                'filename'=> $bill -> getFilename(),
                'file' => $this->urlHelper->getAbsoluteUrl('/bills/'.$bill->getFilename())
            ];
        }
        return new JsonResponse($data,Response::HTTP_OK);
    }
    /**
     * @Route("/bill/consultation/{id}", name="getOneBillByIdConsultation", methods={"GET"})
     */
    public function getBllByIdConsultation($id){
        $prescription = $this->billRepository->findOneBy(['medicalConsultation' => $id]);
        if (!$prescription) {
            throw  new NotFoundHttpException("No existe un archivo con ese id");
        }
        $data=$prescription -> getFilename();

        return new JsonResponse($data,Response::HTTP_OK);
    }

}
