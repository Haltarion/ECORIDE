<?php

namespace App\Security;

use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class CsrfTokenVerifier
{
    public function __construct(private CsrfTokenManagerInterface $csrfManager) {}

    /**
     * Valide le token CSRF pour un id donné.
     * Lance AccessDeniedHttpException si invalide.
     */
    public function assertTokenValid(string $id, ?string $token): void
    {
        $csrfToken = new CsrfToken($id, (string) $token);
        if (!$this->csrfManager->isTokenValid($csrfToken)) {
            throw new AccessDeniedHttpException('Invalid CSRF token.');
        }
    }

    /**
     * Retourne true/false au besoin
     */
    public function isValid(string $id, ?string $token): bool
    {
        return $this->csrfManager->isTokenValid(new CsrfToken($id, (string) $token));
    }
}