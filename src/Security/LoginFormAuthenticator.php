<?php

namespace App\Security;

use App\Service\ApiUsersService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Symfony\Contracts\Translation\TranslatorInterface;

class LoginFormAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';
    public const HOME_ROUTE  = 'app_homepage';

    public function __construct(
        private UrlGeneratorInterface $urlGenerator,
        private ApiUsersService       $apiUsersService,
        private TranslatorInterface   $translator
    ) {
    }

    /**
     * Comprueba si el autenticador va a ser usado para la petición entrante.
     */
    public function supports(Request $request): bool
    {
        return self::LOGIN_ROUTE === $request->attributes->get("_route") && $request->isMethod("POST");
    }

    public function authenticate(Request $request): Passport
    {
        $email    = $request->request->get("email", "");
        $password = $request->request->get("password", "");
        
        $request->getSession()->set(Security::LAST_USERNAME, $email);

        // Comprobación vía API
        $result = $this->apiUsersService->authenticateUser($email, $password);

        if (!$result) {
            throw new CustomUserMessageAuthenticationException($this->translator->trans("Correo electrónico o contraseña incorrectos."));
        }

        return new SelfValidatingPassport(new UserBadge($email));
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return new RedirectResponse($this->urlGenerator->generate(self::HOME_ROUTE));
    }

    protected function getLoginUrl(Request $request): string
    {    
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
    
}
