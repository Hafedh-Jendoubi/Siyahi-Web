<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\HttpUtils;
use Symfony\Component\Routing\RouterInterface;

class AppAuthenticationSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    private $httpUtils;
    private $router;
    private $security;

    public function __construct(HttpUtils $httpUtils, Security $security, RouterInterface $router)
    {
        $this->httpUtils = $httpUtils;
        $this->security = $security;
        $this->router = $router;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token): RedirectResponse
    {
        $user = $token->getUser();

        // Determine the redirect URL based on user role or any other condition
        if ($this->security->isGranted('ROLE_USER')) {
            return new RedirectResponse($this->router->generate('app_user'));
        } else {
            return new RedirectResponse($this->router->generate('app_home'));
        }
    }
}
