<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NavegationController extends AbstractController
{
    #[Route('/home', name: 'app_homepage')]
    public function home(): Response
    {
        return $this->render('navegation/index.html.twig', [
            'controller_name' => 'NavegationController',
        ]);
    }
}
