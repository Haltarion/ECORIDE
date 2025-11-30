<?php

namespace App\Controller\auth;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
  // Injecter le logger si nécessaire
  private LoggerInterface $logger;

  public function __construct(LoggerInterface $logger)
  {
    $this->logger = $logger;
  }
  // Route pour afficher le formulaire de connexion (GET)
  #[Route('/login', name: 'app_login', methods: ['GET', 'POST'])]
  public function login(AuthenticationUtils $authenticationUtils): Response
  {
    // Récupérer les erreurs de connexion s'il y en a
    $error = $authenticationUtils->getLastAuthenticationError();
    $lastUsername = $authenticationUtils->getLastUsername();

    if ($error) {
      $this->logger->error('Erreur de connexion détectée', [
        'message' => $error->getMessageKey(),
        'username' => $lastUsername,
      ]);
    }

    // Rendre la vue du formulaire de connexion
    return $this->render('pages/auth/login.html.twig', [
      'last_username' => $lastUsername,
      'error' => $error,
    ]);
  }
}
