<?php

namespace App\Controller;

use App\Service\ApiUsersService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    public function __construct(
        private ApiUsersService $apiUsersService
    ) {
    }

    #[Route('/users/list', name: 'app_users')]
    public function users(): Response
    {
        return $this->render('user/users.html.twig', [
            'users' => $this->apiUsersService->getUsers(null),
        ]);
    }

    #[Route('/users/list-query', name: 'app_users_query')]
    public function getUsers(?Request $request): JsonResponse
    {
        if(!$this->isGranted("ROLE_ADMIN")) {
            return $this->redirectToRoute("app_homepage");
        }

        $parameters = (empty($request)) ? null : $request->request->all();
        $users = $this->apiUsersService->getUsers($parameters);

        return new JsonResponse($users);
    }
}
