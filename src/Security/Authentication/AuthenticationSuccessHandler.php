<?php

namespace App\Security\Authentication;

use Symfony\Component\Routing\Router;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

class AuthenticationSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    use TargetPathTrait;

    public function __construct(
        private Security $security,
        private Router $router
    ) {
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token): Response
    {
        if ($this->security->isGranted('ROLE_SHELTER_EMPLOYEE') || $this->security->isGranted('ROLE_SHELTER_ADMIN')) {
            return new RedirectResponse($this->router->generate('app_admin_shelter_dashboard'));
        }

        // Redirect classic users to the previous page
        if ($this->security->isGranted('ROLE_USER')) {
            $targetPath = $this->getTargetPath(
                $request->getSession(),
                $this->security->getFirewallConfig($request)
            );

            if ($targetPath) {
                return new RedirectResponse($targetPath);
            }
        }

        return new RedirectResponse($this->router->generate('app_main'));
    }
}