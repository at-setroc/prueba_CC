<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/users/list', name: 'app_users')]
    public function users(): Response
    {
        return $this->render('user/users.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
}
