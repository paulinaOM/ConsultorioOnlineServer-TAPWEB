<?php

namespace App\Controller;

use App\Repository\PrescriptionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\UrlHelper;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class PrescriptionController extends AbstractController
{
    //constructor
    private $prescriptionRepository;
    private $urlHelper;

    public function __construct(PrescriptionRepository $prescriptionRepository, UrlHelper $urlHelper){
        $this->prescriptionRepository=$prescriptionRepository;
        $this->urlHelper = $urlHelper;
    }

    /**
     * @Route("/prescription", name="prescription", methods={"POST"})
     */
    public function add(Request $request): JsonResponse
    {
        $dataFile = $request->get('file');

        if(!empty($dataFile)){
            $data = base64_decode($dataFile);
            // print_r($data);
            $filename=sprintf('%s.%s',uniqid("m_",true),"pdf");
            file_put_contents( $this->getParameter('prescription_directory').$filename, $data );
            $idMedicalConsultation=$request->get('id_consultation');
        } else {
            echo "No Data Sent";
        }

        if(empty($idMedicalConsultation)||empty($filename)){
            throw  new NotFoundHttpException("Se esperaban parámetros");
        }
        $this->prescriptionRepository->savePrescription($idMedicalConsultation,$filename);
        return new JsonResponse(['status'=>'Prescripcion creada'],Response::HTTP_CREATED);
    }

    /**
     * @Route("/prescription", name="getAllPrescriptions", methods={"GET"})
     */
    public function  getAll():JsonResponse{
        $prescriptions=$this->prescriptionRepository->findAll();
        $data=Array();
        foreach ($prescriptions as $prescription){
            $data[]=[
                'id'=>$prescription->getId(),
                'id_consultation'=>$prescription->getIdConsultation()->getId(),
                'filename'=> $prescription -> getFilename(),
                'file' => $this->urlHelper->getAbsoluteUrl('/prescriptions/'.$prescription->getFilename())
            ];
        }
        return new JsonResponse($data,Response::HTTP_OK);
    }

    /**
     * @Route("/prescription/{id}", name="getOneprescription", methods={"GET"})
     */
    public function showAction($id){
        $prescription = $this->prescriptionRepository->find($id);
        if (!$prescription) {
            throw  new NotFoundHttpException("No existe un archivo con ese id");
        }
        $data=Array(
            'id'=>$prescription->getId(),
            'filename'=>$prescription->getFilename(),
            'id_consultation'=>$prescription->getIdConsultation()->getId(),
            'file' => $this->urlHelper->getAbsoluteUrl('/prescriptions/'.$prescription->getFilename())
        );

        return new JsonResponse($data,Response::HTTP_OK);
    }
    /**
     * @Route("/patient/{id}/prescriptions", name="getPrescriptionPatient", methods={"GET"})
     */
    public function  getPrescriptionPatient($id):JsonResponse{
        $prescriptions=$this->prescriptionRepository->getPrescriptionsByPatient($id);

        $data=Array();
        foreach ($prescriptions as $prescription){
            $data[]=[
                'id'=>$prescription->getId(),
                'id_consultation'=>$prescription->getIdConsultation()->getId(),
                'filename'=> $prescription -> getFilename(),
                'file' => $this->urlHelper->getAbsoluteUrl('/prescriptions/'.$prescription->getFilename())
            ];
        }
        return new JsonResponse($data,Response::HTTP_OK);
    }
    /**
     * @Route("/doctor/{id}/prescriptions", name="getPrescriptionByDoctor", methods={"GET"})
     */
    public function  getPrescriptionByDoctor($id):JsonResponse{
        $prescriptions=$this->prescriptionRepository->getPrescriptionsByDoctor($id);

        $data=Array();
        foreach ($prescriptions as $prescription){
            $data[]=[
                'id'=>$prescription->getId(),
                'id_consultation'=>$prescription->getIdConsultation()->getId(),
                'filename'=> $prescription -> getFilename(),
                'file' => $this->urlHelper->getAbsoluteUrl('/prescriptions/'.$prescription->getFilename())
            ];
        }
        return new JsonResponse($data,Response::HTTP_OK);
    }
    /**
     * @Route("/prescription/consultation/{id}", name="getOneprescriptionByIdConsultation", methods={"GET"})
     */
    public function getPrescriptionByIdConsultation($id){
        $prescription = $this->prescriptionRepository->findOneBy(['medicalConsultation' => $id]);
        if (!$prescription) {
            throw  new NotFoundHttpException("No existe un archivo con ese id");
        }
        $data=$prescription -> getFilename();

        return new JsonResponse($data,Response::HTTP_OK);
    }

}

