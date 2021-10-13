<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/admin/user', name: 'admin_user_index')]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('admin/user/index.html.twig', [
            'controller_name' => 'UserController',
            'users'=>$userRepository->findBy([], ['lastName'=>'asc'])
        ]);
    }

    #[Route('/admin/user/edit/{id}', name: 'admin_user_edit', methods: ['GET', 'POST'])]
    public function edit(UserRepository $userRepository,  Request $request, $id=''): Response
    {
        $user = $id?$userRepository->find($id):new User();
        if(!$user){
            throw new NotFoundHttpException('User was not found in the database');
        }
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->save($user);
            return $this->redirectToRoute('admin_user_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('admin/user/edit.html.twig', [
            'controller_name' => 'UserController',
            'form'=>$form->createView()
        ]);
    }
}
