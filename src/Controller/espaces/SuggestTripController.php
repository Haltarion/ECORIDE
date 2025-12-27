<?php

namespace App\Controller\espaces;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\VehiculeInfoService;

class SuggestTripController extends AbstractController
{
  /**
  * Affiche la page de suggestion de trajet.
  * @return Response
  */
  #[Route('/suggest-trip', name: 'app_suggest_trip')]
  public function index(): Response
  {
    return $this->render('pages/espaces/suggest-trip.html.twig');
  }

  /**
  * Vérification centralisée : token CSRF + authentification
  * @param array $data
  * @param string $tokenId
  * @return User L'utilisateur authentifié
  */
  private function verifySecurityAndGetUser(array $data, string $tokenId = 'profile-change')
  {
    $this->csrfVerifier->assertTokenValid($tokenId, $data['_csrf_token'] ?? '');
    return $this->userProvider->getAuthenticatedUser();
  }

  /**
  * Récupération des informations des véhicules de l'utilisateur
  * @param VehiculeInfoService $vehiculeInfoService
  * @return Response
  */
  #[Route('/suggest-trip/vehicules', name: 'app_suggest_trip_vehicules')]
  public function vehicules(VehiculeInfoService $vehiculeInfoService): Response
  {
    $user = $this->getUser();

    if (!$user) {
      throw $this->createAccessDeniedException('Utilisateur non authentifié.');
    }

    $voitures = $vehiculeInfoService->getVoituresInfosByUser($user);

    return $this->json(['voitures' => $voitures]);
  }
}
