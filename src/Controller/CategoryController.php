<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Feature;
use App\Form\PurchaseOrderType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends AbstractController
{
    public function __construct(ManagerRegistry $registry) 
    {
        $this->em = $registry->getManager();
    }

    #[Route('/categories/{num}/features', name: 'app_form_features')]
    public function formFeatures(Request $request): Response
    {
        $categoryId = $request->attributes->get("num");
        $category   = $this->em->getRepository(Category::class)->findOneby([
            "id"        => $categoryId,
            "active"  => true,
            "hasForm"   => true
        ]);
        $features   = $this->em->getRepository(Feature::class)->findBy([
            "category"  => $category,
            "active"  => true
        ],[
            "formOrder" => "ASC"
        ]);

        // Si no encontramos la categoría o no hay características, redirigimos a la home
        if (!$category || empty($features)) {
            return $this->redirectToRoute("app_homepage");
        }

        $form = $this->createForm(PurchaseOrderType::class, $features);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            // TODO: Llamar a servicio para realizar el guardado

            dd($form->getData());


            // TODO: Notificación de formulario guardado

            return $this->redirectToRoute("app_homepage");
        }

        return $this->render('category/form_features.html.twig', [
            "category" => $category,
            "features" => $features,
            "form"     => $form->createView()
        ]);
    }

}
