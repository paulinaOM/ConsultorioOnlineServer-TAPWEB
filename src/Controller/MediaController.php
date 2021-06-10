<?php

namespace App\Controller;

use App\Repository\MediaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\UrlHelper;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

use App\Service;



/**
 * Class MediaController
 * @package App\Controller*
 *

 */


class MediaController extends AbstractController
{
    //constructor
    private $mediaRepository, $urlHelper;
    public function __construct(MediaRepository $mediaRepository, UrlHelper $urlHelper){
        $this->mediaRepository=$mediaRepository;
        $this->urlHelper = $urlHelper;
    }
    /**
     * @Route("/media", name="media", methods={"POST"})
     */
    public function add(Request $request): JsonResponse
    {
        $dataFile = $request->files->get('file');
        $fileTitle = sprintf('%s.%s',uniqid("m_",true),"jpg");
        $dataFile->move($this->getParameter('media_directory'),$fileTitle); // moves the file to the directory where media are stored

        $filename=$fileTitle;
        $id_consultation=$request->get('id_consultation');

        if(empty($filename)||empty($id_consultation)){
            throw  new NotFoundHttpException("Se esperaban parámetros");
        }
        $this->mediaRepository->saveMedia($filename,$id_consultation);
        return new JsonResponse(['status'=>'Media creado'],Response::HTTP_CREATED);
    }
    /**
     * @Route("/media", name="getAllMedias", methods={"GET"})
     */
    public function  getAll():JsonResponse{
        $medias=$this->mediaRepository->findAll();
        $data=Array();
        foreach ($medias as $media){
            $data[]=[
                'id'=>$media->getId(),
                'filename'=>$media->getFilename(),
                'id_consultation'=>$media->getIdConsultation()->getId(),
                'image' => $this->urlHelper->getAbsoluteUrl('/storage/'.$media->getFilename())

            ];
        }
        return new JsonResponse($data,Response::HTTP_OK);

    }
    /**
     * @Route("/media/{id}", name="getOneMedia", methods={"GET"})
     */
    public function showAction($id)
    {
        $media = $this->mediaRepository->find($id);
        if (!$media) {
            throw  new NotFoundHttpException("No existe un archivo con ese id");
        }
        $data=Array(
            'id'=>$media->getId(),
            'filename'=>$media->getFilename(),
            'id_consultation'=>$media->getIdConsultation()->getId(),
            'image' => $this->urlHelper->getAbsoluteUrl('/storage/'.$media->getFilename())
        );

        return new JsonResponse($data,Response::HTTP_OK);


    }
    /**
     * @Route("/media/consultation/{id}", name="getMediaByConsultation", methods={"GET"})
     */
    public function  getMediaByConsultation($id):JsonResponse
    {
        $media = $this->mediaRepository->findOneBy(['consultation' => $id]);

        if ($media) {
            $data = [
                'id'=>$media->getId(),
                'filename'=>$media->getFilename(),
                'id_consultation'=>$media->getIdConsultation()->getId(),
                'image' => $this->urlHelper->getAbsoluteUrl('/storage/'.$media->getFilename())            ];

            return new JsonResponse($data, Response::HTTP_OK);
        } else {
            return new JsonResponse(['status' => 'Consulta no encontrada'], Response::HTTP_NOT_FOUND);
        }
    }



}
