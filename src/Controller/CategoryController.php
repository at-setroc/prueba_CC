<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoryRepository;
use App\Repository\FeatureRepository;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends AbstractController
{
    public function __construct(
        private CategoryRepository $categoryRepository,
        private FeatureRepository  $featureRepository
    ) {
    }

    #[Route('/categories/{num}/features', name: 'app_form_features')]
    public function formFeatures(Request $request): Response
    {
        $categoryId = $request->attributes->get("num");
        
        $category   = $this->categoryRepository->findOneby([
            "id"        => $categoryId,
            "isActive"  => true,
            "hasForm"   => true
        ]);

        $features   = $this->featureRepository->findBy([
            "category"  => $category,
            "isActive"  => true
        ],[
            "formOrder" => "ASC"
        ]);

        // Si no encontramos la categoría o no hay características, redirigimos a la home
        if (!$category || empty($features)) {
            return $this->redirectToRoute("app_homepage");
        }

        return $this->render('category/form_features.html.twig', [
            'category' => $category,
            'features' => $features,
        ]);
    }

}
