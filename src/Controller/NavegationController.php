<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NavegationController extends AbstractController
{
    public function __construct(
        private CategoryRepository $categoryRepository
    ) {
    }

    #[Route('/', name: 'app_root')]
    public function index(): Response
    {
        return $this->redirectToRoute("app_homepage");
    }

    #[Route('/home', name: 'app_homepage')]
    public function home(): Response
    {
        $mainCategories = $this->categoryRepository->findMainCategories();

        return $this->render('navegation/home.html.twig', [
            'mainCategories' => $mainCategories,
        ]);
    }
    
    #[Route('/users', name: 'app_redirect_users')]
    public function usersRedirect(): Response
    {
        return $this->redirectToRoute("app_users");
    }

    #[Route('/categories', name: 'app_redirect_categories')]
    public function categoriesRedirect(): Response
    {
        return $this->redirectToRoute("app_homepage");
    }

}
