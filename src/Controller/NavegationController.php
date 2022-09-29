<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NavegationController extends AbstractController
{
    #[Route('/', name: 'app_root')]
    public function index(): Response
    {
        return $this->redirectToRoute("app_homepage");
    }

    #[Route('/home', name: 'app_homepage')]
    public function home(): Response
    {
        return $this->render('navegation/home.html.twig', [
            'controller_name' => 'NavegationController',
        ]);
    }
}
