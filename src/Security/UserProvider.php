<?php

namespace App\Security;

use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Security\Core\User\UserInterface;

class UserProvider
{
    public function __construct(private Security $security) {}

    /**
     * Retourne l'utilisateur authentifié ou lance AccessDeniedHttpException.
     */
    public function getAuthenticatedUser(): UserInterface
    {
        $user = $this->security->getUser();
        if (!$user) {
            throw new AccessDeniedHttpException('Not authenticated.');
        }
        return $user;
    }
}