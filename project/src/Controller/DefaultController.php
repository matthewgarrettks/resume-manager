<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="home", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('default/home.html.twig', [
        ]);
    }
    /**
     * @Route("/b", name="bhome", methods={"GET"})
     */
    public function bindex(): Response
    {
        echo "b";
        return $this->render('default/home.html.twig', [
        ]);
    }
}
