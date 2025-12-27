<?php

namespace App\Controller\espaces;

use App\Entity\User;
use App\Entity\Voiture;
use App\Service\VehiculeInfoService;
use App\Security\UserProvider;
use App\Repository\VoitureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Security\CsrfTokenVerifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ModifVehicleController extends AbstractController
{
  private CsrfTokenVerifier $csrfVerifier;
  private UserProvider $userProvider;
  private VehiculeInfoService $vehiculeInfoService;

  public function __construct(CsrfTokenVerifier $csrfVerifier, UserProvider $userProvider, VehiculeInfoService $vehiculeInfoService)
  {
    $this->csrfVerifier = $csrfVerifier;
    $this->userProvider = $userProvider;
    $this->vehiculeInfoService = $vehiculeInfoService;
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

  /**
   * Récupération des informations d'un véhicule pour modification
   */
  #[Route('/modif-vehicle/{id}', name: 'app_modif_vehicle')]
  public function index(int $id, VehiculeInfoService $vehiculeInfoService): Response
  {
    $user = $this->getUser();

    // Si l'utilisateur n'est pas connecté, on affiche la page de connection
    if (!$user) {
      return $this->redirectToRoute('app_login');
    }

    // Récupérer les informations de la voiture
    $voitures = $vehiculeInfoService->getVoituresInfosByUser($user);

    // Trouver la voiture correspondante à l'ID
    $voiture = null;
    foreach ($voitures as $v) {
      if ($v['id'] === $id) {
        $voiture = $v;
        break;
      }
    }

    // Si la voiture n'existe pas ou n'appartient pas à l'utilisateur
    if (!$voiture) {
      $this->addFlash('error', 'Véhicule introuvable.');
      return $this->redirectToRoute('app_user_vehicle');
    }

    return $this->render('pages/espaces/modif-vehicle.html.twig', [
      'voiture' => $voiture,
    ]);
  }

  /**
   * Récupération des données modifiées
   * et enregristrement en base de données
   */
  #[Route('/user-vehicle/edit/{id}', name: 'app_user_vehicle_edit', methods: ['POST'])]
  public function editVehicle(int $id, Request $request, EntityManagerInterface $entityManager, VoitureRepository $voitureRepository): Response
  {
    // Vérification token CSRF et authentification
    $data = json_decode($request->getContent(), true) ?? [];
    // fallback pour form post
    if (empty($data) && $request->request->has('_csrf_token')) {
        $data = $request->request->all();
    }
    $user = $this->verifySecurityAndGetUser($data, 'update-vehicle');

    // Récupérer le véhicule existant
    $vehicle = $voitureRepository->find($id);

    if (!$vehicle) {
      $this->addFlash('error', 'Véhicule introuvable.');
      return $this->redirectToRoute('app_user_vehicle');
    }

    // Vérifier que le véhicule appartient à l'utilisateur
    if ($vehicle->getUser() !== $user) {
      $this->addFlash('error', 'Accès non autorisé.');
      return $this->redirectToRoute('app_user_vehicle');
    }

    // Mise à jour des informations
    // Date: accepter soit 'premiereImmatriculation' (form), soit 'date_premiere_immatriculation' (JSON)
    $dateStr = $data['premiereImmatriculation'] ?? ($data['date_premiere_immatriculation'] ?? null);
    if ($dateStr) {
      $dateObj = \DateTime::createFromFormat('Y-m-d', $dateStr);
      if (!$dateObj) {
        $this->addFlash('error', 'Format de date invalide.');
        return $this->redirectToRoute('app_modif_vehicle', ['id' => $id]);
      }
      $vehicle->setDatePremiereImmatriculation($dateObj);
    }

    if (isset($data['marque'])) {
      $vehicle->setMarque($data['marque']);
    }
    if (isset($data['modele'])) {
      $vehicle->setModele($data['modele']);
    }

    // Si la checkbox est cochée, elle aura la valeur "1"
    $electrique = isset($data['electrique']) ? 1 : 0;
    $vehicle->setElectrique($electrique);

    if (isset($data['couleur'])) {
      $vehicle->setCouleur($data['couleur']);
    }

    // Nombre de places: accepter 'placesDispo' (form) ou 'nb_place_dispo' (JSON), borné 1..6
    if (isset($data['placesDispo']) || isset($data['nb_place_dispo'])) {
      $places = (int)($data['placesDispo'] ?? ($data['nb_place_dispo'] ?? 1));
      if ($places < 1) { $places = 1; }
      if ($places > 6) { $places = 6; }
      $vehicle->setNbPlaceDispo($places);
    }

    // Sauvegarde en base de données
    $entityManager->flush();

    $this->addFlash('success', 'Véhicule modifié avec succès.');
    return $this->redirectToRoute('app_user_vehicle');
  }
}
