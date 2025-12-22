<?php

namespace App\Controller\espaces;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Entity\Voiture;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Security\CsrfTokenVerifier;
use App\Security\UserProvider;

class UserVehicleController extends AbstractController
{
  private CsrfTokenVerifier $csrfVerifier;
  private UserProvider $userProvider;

  public function __construct(CsrfTokenVerifier $csrfVerifier, UserProvider $userProvider)
  {
    $this->csrfVerifier = $csrfVerifier;
    $this->userProvider = $userProvider;
  }

  /**
   * Vérification centralisée : token CSRF + authentification
   * @return User L'utilisateur authentifié
   */
  private function verifySecurityAndGetUser(array $data, string $tokenId = 'profile-change')
  {
    $this->csrfVerifier->assertTokenValid($tokenId, $data['_csrf_token'] ?? '');
    return $this->userProvider->getAuthenticatedUser();
  }

  #[Route('/user-vehicle', name: 'app_user_vehicle')]
  public function index(): Response
  {
    return $this->render('pages/espaces/user-vehicle.html.twig');
  }

  /**
   * Récupération des données du nouveau véhicule
   */

  #[Route('/user-vehicle/new', name: 'app_user_vehicle_new', methods: ['POST'])]

  public function newVehicle(Request $request, EntityManagerInterface $entityManager): JsonResponse
  {
    // Vérification token CSRF et authentification
    $data = json_decode($request->getContent(), true) ?? [];
    // fallback pour form post
    if (empty($data) && $request->request->has('_csrf_token')) {
        $data = $request->request->all();
    }
    $user = $this->verifySecurityAndGetUser($data, 'new-vehicle');

    // Création du nouveau véhicule
    $vehicle = new Voiture();
    $vehicle->setUser($user);
    $vehicle->setImmatriculation($data['immatriculation'] ?? '');
    $vehicle->setMarque($data['marque'] ?? '');
    $vehicle->setModele($data['modele'] ?? '');
    $vehicle->setCouleur($data['couleur'] ?? '');
    $vehicle->setAnnee((int)($data['annee'] ?? 0));
    $vehicle->setTypeCarburant($data['typeCarburant'] ?? '');

    // Persistance en base de données
    $entityManager->persist($vehicle);
    $entityManager->flush();

    return new JsonResponse(['status' => 'success', 'message' => 'Véhicule ajouté avec succès.']);
  }
}

