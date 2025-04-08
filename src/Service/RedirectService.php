<?php

namespace App\Service;

use Psr\Log\LoggerInterface;
use App\Service\ShelterService;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Redirects the user based on their role.
 * 
 * @param Request $request
 * @return RedirectResponse
 */
class RedirectService
{
    use TargetPathTrait;

    public function __construct(
        private Security $security,
        private RouterInterface $router,
        private ShelterService $shelterService,
        private LoggerInterface $logger
    ) {
    }

    public function redirectBasedOnRole(Request $request): RedirectResponse
    {
        // If the user is a shelter user (employee or admin), redirect to shelter dashboard
        if ($this->shelterService->isShelterUser()) {
            return $this->redirectToShelter($request);
        }

        // If the user has a ROLE_USER, redirect to the previous page they were on
        if ($this->security->isGranted('ROLE_USER')) {
            return $this->redirectToPreviousPage($request);
        }

        // Default redirect if no matching roles
        return $this->redirectToDefault();
    }

    private function redirectToShelter(Request $request): RedirectResponse
    {
        // Log an error with the user ID when the user has a shelter role but no shelter is associated
        if (!$this->shelterService->hasAssociatedShelter()) {
            $this->logger->error('User with ROLE_SHELTER_* attempted to access the shelter dashboard, but no shelter is associated with their account. User ID: {userId}', ['userId' => $this->security->getUser()->getId()]);

            // Throw an exception to deny access and inform the user to contact the admin
            throw new AccessDeniedException("You are assigned a shelter role but no shelter is associated with your account. Please contact the admin for assistance.");

        }

        // If everything is fine, redirect to the shelter dashboard
        return new RedirectResponse($this->router->generate('app_shelter_dashboard'));
    }

    private function redirectToPreviousPage(Request $request): RedirectResponse
    {
        $targetPath = $this->getTargetPath(
            $request->getSession(),
            'main'
        );

        if ($targetPath) {
            return new RedirectResponse($targetPath);
        }

        return new RedirectResponse($this->router->generate('app_home'));
    }

    private function redirectToDefault(): RedirectResponse
    {
        return new RedirectResponse($this->router->generate('app_home'));
    }
}