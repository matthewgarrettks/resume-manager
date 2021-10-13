<?php

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WorkExperienceController extends AbstractController
{
    #[Route('/user/work/experience', name: 'user_work_experience')]
    public function index(): Response
    {
        return $this->render('user/work_experience/index.html.twig', [
            'controller_name' => 'WorkExperienceController',
        ]);
    }
}
