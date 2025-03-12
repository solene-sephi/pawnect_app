<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectService
{
    use TargetPathTrait;

    public function __construct(
        private Security $security,
        private RouterInterface $router
    ) {
    }

    public function redirectBasedOnRole(Request $request): Response
    {
        if ($this->security->isGranted('ROLE_SHELTER_EMPLOYEE') || $this->security->isGranted('ROLE_SHELTER_ADMIN')) {
            return new RedirectResponse($this->router->generate('app_shelter_dashboard'));
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

        return new RedirectResponse($this->router->generate('app_home'));
    }
}