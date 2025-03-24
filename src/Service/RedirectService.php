<?php

namespace App\Service;

use App\Service\ShelterService;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class RedirectService
{
    use TargetPathTrait;

    public function __construct(
        private Security $security,
        private RouterInterface $router,
        private ShelterService $shelterService
    ) {
    }

    public function redirectBasedOnRole(Request $request): Response
    {
        if ($this->shelterService->shouldRedirectToShelterDashboard()) {
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