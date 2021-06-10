<?php

namespace App\Controller;

use App\Repository\UserdataRepository;

use PhpParser\Node\Expr\Array_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserController
 * @package App\Controller*
 *

 */

class UserController
{
    //constructor
    private $userdataRepository;
    public function __construct(UserdataRepository $userdataRepository){
        $this->userdataRepository=$userdataRepository;
    }
    /**
     * @Route("/user", name="user", methods={"POST"})
     */
    public function add(Request $request): JsonResponse
    {
        $data=json_decode($request->getContent(),true);
        $username=$data['username'];
        $pwd=md5($data['pwd']);
        $role=$data['role'];

        if(empty($username)||empty($pwd)||empty($role)){
            throw  new NotFoundHttpException("Se esperaban parámetros");
        }
        $this->userdataRepository->saveUser($username,$pwd,$role);
        return new JsonResponse(['status'=>'Usuario creado'],Response::HTTP_CREATED);
    }
    /**
     * @Route("/user", name="getAllUsers", methods={"GET"})
     */
    public function  getAll():JsonResponse{
        $users=$this->userdataRepository->findAll();
        $data=Array();
        foreach ($users as $user){
            $data[]=[
                'id'=>$user->getId(),
                'username'=>$user->getUsername(),
                'pwd'=>$user->getPwd(),
                'role'=>$user->getRole(),
            ];
        }
        return new JsonResponse($data,Response::HTTP_OK);

    }
    /**
     * @Route("/user/{id}", name="getOneUser", methods={"GET"})
     */
    public function showAction($id)
    {
        $user = $this->userdataRepository->find($id);
        if (!$user) {
            throw  new NotFoundHttpException("No existe un usuario con ese id");
        }
        $data=Array(
            'id' => $user->getId(),
            'username'=>$user->getUsername(),
            'pwd'=>$user->getPwd(),
            'role'=>$user->getRole()

        );

        return new JsonResponse($data,Response::HTTP_OK);


    }
    /**
     * @Route("/username/{username}", name="getOneUsername", methods={"GET"})
     */
    public function findUser($username)
    {
        $user = $this->userdataRepository->findOneBySomeField($username);
        if (!$user) {
            //throw  new NotFoundHttpException("No existe un usuario con ese username");

            return new JsonResponse(null,Response::HTTP_OK);
        }
        $data=Array(
            'id' => $user->getId(),
            'username'=>$user->getUsername(),
            'pwd'=>$user->getPwd(),
            'role'=>$user->getRole()

        );

        return new JsonResponse($data,Response::HTTP_OK);


    }
    /**
     * @Route("/login", name="login", methods={"POST"})
     */
    public function login(Request $request)
    {
        $data=json_decode($request->getContent(),true);
        $username=$data['username'];
        $pwd=md5($data['pwd']);

        if(empty($username)||empty($pwd)){
            throw  new NotFoundHttpException("Se esperaban parámetros");
        }
        $user =$this->userdataRepository->login($username,$pwd);
        if (!$user) {
            //throw  new NotFoundHttpException("No existe un usuario con ese username");
            return new JsonResponse(null,Response::HTTP_OK);
        }
        $data=Array(
            'id' => $user->getId(),
            'username'=>$user->getUsername(),
            'pwd'=>$user->getPwd(),
            'role'=>$user->getRole()
        );

        return new JsonResponse($data,Response::HTTP_OK);



    }
    /**
     * @Route("/userlast", name="getLastId", methods={"GET"})
     */
    public function  getLastId():JsonResponse{
        $users=$this->userdataRepository->findAll();
        $data=Array();
        foreach ($users as $user){
            $data[]=[
                'id'=>$user->getId(),
                'username'=>$user->getUsername(),
                'pwd'=>$user->getPwd(),
                'role'=>$user->getRole(),
            ];
        }
        return new JsonResponse(end($data),Response::HTTP_OK);

    }
}
