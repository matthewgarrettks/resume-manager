<?php

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PersonController extends AbstractController
{
    #[Route('/user/person', name: 'user_person')]
    public function index(): Response
    {
        return $this->render('user/person/index.html.twig', [
            'controller_name' => 'PersonController',
        ]);
    }
}
