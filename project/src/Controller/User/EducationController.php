<?php

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EducationController extends AbstractController
{
    #[Route('/user/education', name: 'user_education')]
    public function index(): Response
    {
        return $this->render('user/education/index.html.twig', [
            'controller_name' => 'EducationController',
        ]);
    }
}
