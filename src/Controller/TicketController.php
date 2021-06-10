<?php

namespace App\Controller;

use App\Repository\TicketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\UrlHelper;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class TicketController extends AbstractController
{
    //constructor
    //constructor
    private $ticketRepository;
    private $urlHelper;

    public function __construct(TicketRepository $ticketRepository, UrlHelper $urlHelper){
        $this->ticketRepository=$ticketRepository;
        $this->urlHelper = $urlHelper;
    }
    /**
     * @Route("/patient/{id}/tickets", name="getTicketPatient", methods={"GET"})
     */
    public function  getTicketPatient($id):JsonResponse{
        $tickets=$this->ticketRepository->getTicketsByPatient($id);

        $data=Array();
        foreach ($tickets as $ticket){
            $data[]=[
                'id'=>$ticket->getId(),
                'id_patient'=>$ticket->getIdPatient(),
                'date_sale' => $ticket->getDateSale()->format('Y-m-d'),
                'filename'=> $ticket -> getFilename(),
                'file' => $this->urlHelper->getAbsoluteUrl('/tickets/'.$ticket->getFilename())
            ];
        }
        return new JsonResponse($data,Response::HTTP_OK);
    }
    /**
     * @Route("/ticket", name="tickets", methods={"POST"})
     */
    public function add(Request $request): JsonResponse
    {
        $dataFile = $request->get('file');

        if(!empty($dataFile)){
            $data = base64_decode($dataFile);
            $filename=sprintf('%s.%s',uniqid("t_",true),"pdf");
            file_put_contents( $this->getParameter('ticket_directory').$filename, $data );
            $idPatient=$request->get('id_patient');
            $dateSale = date("Y-m-d");
        } else {
            echo "No Data Sent";
        }

        if(empty($idPatient)||empty($filename)||empty($dateSale)){
            throw  new NotFoundHttpException("Se esperaban parámetros");
        }
        $this->ticketRepository->saveTicket($idPatient,$dateSale,$filename);
        return new JsonResponse(['status'=>'Ticket creado'],Response::HTTP_CREATED);
    }

    /**
     * @Route("/ticket/last", name="getLastTicket", methods={"GET"})
     */
    public function  getLast():JsonResponse{
        $lastTicket=$this->ticketRepository->findLast();
        return new JsonResponse($lastTicket->getId(),Response::HTTP_OK);
    }


}
