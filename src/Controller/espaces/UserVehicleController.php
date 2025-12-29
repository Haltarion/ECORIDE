<?php

namespace App\Controller\espaces;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Entity\Voiture;
use App\Service\TextNormalizerService;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\VoitureRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Security\CsrfTokenVerifier;
use App\Security\UserProvider;
use App\Service\VehiculeInfoService;

class UserVehicleController extends AbstractController
{
  private CsrfTokenVerifier $csrfVerifier;
  private UserProvider $userProvider;
  private TextNormalizerService $textNormalizer;

  public function __construct(CsrfTokenVerifier $csrfVerifier, UserProvider $userProvider, TextNormalizerService $textNormalizer)
  {
    $this->csrfVerifier = $csrfVerifier;
    $this->userProvider = $userProvider;
    $this->textNormalizer = $textNormalizer;
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
  * Affichage des véhicules de l'utilisateur
  * @param VehiculeInfoService $vehiculeInfoService
  * @return Response
  */
  #[Route('/user-vehicle', name: 'app_user_vehicle')]
  public function index(VehiculeInfoService $vehiculeInfoService): Response
  {
    $user = $this->getUser();

    // Si l'utilisateur n'est pas connecté, on affiche la page avec une liste vide
    if (!$user) {
      return $this->render('pages/espaces/user-vehicle.html.twig', [
        'voitures' => [],
      ]);
    }

    $voitures = $vehiculeInfoService->getVoituresInfosByUser($user);

    return $this->render('pages/espaces/user-vehicle.html.twig', [
      'voitures' => $voitures,
    ]);
  }

  /**
  * Vérification de l'existence d'une immatriculation
  * @param Request $request
  * @param VoitureRepository $voitureRepository
  * @return JsonResponse
  */
  #[Route('/user-vehicle/check-immatriculation', name: 'app_check_immatriculation', methods: ['POST'])]
  public function checkImmatriculation(Request $request, VoitureRepository $voitureRepository): JsonResponse
  {
    $data = json_decode($request->getContent(), true) ?? [];
    if (empty($data)) {
      $data = $request->request->all();
    }
    $immatriculation = trim($data['immatriculation'] ?? '');

    if ($immatriculation === '') {
      return new JsonResponse(['exists' => false]);
    }

    $exists = $voitureRepository->findOneBy(['immatriculation' => $immatriculation]) !== null;
    return new JsonResponse(['exists' => $exists]);
  }

  /**
  * Récupération des données du nouveau véhicule
  * et enregristrement en base de données
  * @param Request $request
  * @param EntityManagerInterface $entityManager
  * @return Response
  */
  #[Route('/user-vehicle/new', name: 'app_user_vehicle_new', methods: ['POST'])]

  public function newVehicle(Request $request, EntityManagerInterface $entityManager): Response
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
    // Date: accepter soit 'premiereImmatriculation' (form), soit 'date_premiere_immatriculation' (JSON)
    $dateStr = $data['premiereImmatriculation'] ?? ($data['date_premiere_immatriculation'] ?? null);
    if ($dateStr) {
      $dateObj = \DateTime::createFromFormat('Y-m-d', $dateStr);
      if (!$dateObj) {
        return new JsonResponse([
          'status' => 'error',
          'message' => 'Format de date invalide (attendu YYYY-MM-DD).',
        ], 422);
      }
      $vehicle->setDatePremiereImmatriculation($dateObj);
    } else {
      return new JsonResponse([
        'status' => 'error',
        'message' => 'Date de première immatriculation manquante.',
      ], 422);
    }
    $vehicle->setMarque($this->textNormalizer->removeAccents($data['marque'] ?? ''));
    $vehicle->setModele($this->textNormalizer->removeAccents($data['modele'] ?? ''));
    // Si la checkbox est cochée, elle aura la valeur "1"
    // Si elle n'est pas cochée, la clé ne sera pas présente (vous devez utiliser ?? 0)
    $electrique = isset($data['electrique']) ? 1 : 0;
    $vehicle->setElectrique($electrique);
    $vehicle->setCouleur($this->textNormalizer->removeAccents($data['couleur'] ?? ''));
    // Nombre de places: accepter 'placesDispo' (form) ou 'nb_place_dispo' (JSON), borné 1..6
    $places = (int)($data['placesDispo'] ?? ($data['nb_place_dispo'] ?? 1));
    if ($places < 1) { $places = 1; }
    if ($places > 6) { $places = 6; }
    $vehicle->setNbPlaceDispo($places);

    // Persistance en base de données
    $entityManager->persist($vehicle);
    $entityManager->flush();

    return $this->redirectToRoute('app_user_vehicle');
  }

  /**
  * Affichage des véhicules dans le profil utilisateur
  * @param VehiculeInfoService $vehiculeInfoService
  * @return Response
  */
  #[Route('/profil/vehicules', name: 'profil_vehicules')]
  public function vehicules(VehiculeInfoService $vehiculeInfoService): Response
  {
    $user = $this->getUser();

    if (!$user) {
      throw $this->createAccessDeniedException('Utilisateur non authentifié.');
    }

    $voitures = $vehiculeInfoService->getVoituresInfosByUser($user);

    return $this->render('profil/vehicules.html.twig', [
      'voitures' => $voitures,
    ]);
  }
}

