<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/categories', name: 'app_categories')]
    public function index(): Response
    {
        return $this->render('category/categories.html.twig', [
            'controller_name' => 'CategoryController',
        ]);
    }
}
