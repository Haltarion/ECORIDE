<?php

namespace App\Controller\espaces;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Entity\Voiture;
use App\Entity\UserExtras;
use App\Entity\Profil;
use App\Entity\Preferences;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Security\CsrfTokenVerifier;
use App\Security\UserProvider;
use App\Service\VehiculeInfoService;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class UserSpaceController extends AbstractController
{
  private CsrfTokenVerifier $csrfVerifier;
  private UserProvider $userProvider;
  private UserPasswordHasherInterface $hasher;
  private VehiculeInfoService $vehiculeInfoService;

  public function __construct(CsrfTokenVerifier $csrfVerifier, UserProvider $userProvider, UserPasswordHasherInterface $hasher, VehiculeInfoService $vehiculeInfoService)
  {
    $this->csrfVerifier = $csrfVerifier;
    $this->userProvider = $userProvider;
    $this->hasher = $hasher;
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
   * Initialise les profils "Passager" et "Chauffeur" en base de données s'ils n'existent pas
   */
  private function ensureProfilsExist(EntityManagerInterface $em): void
  {
    $profilRepo = $em->getRepository(Profil::class);

    // Vérifier et créer "Passager" si nécessaire
    $passager = $profilRepo->findOneBy(['libelle' => 'Passager']);
    if (!$passager) {
      $passager = new Profil();
      $passager->setLibelle('Passager');
      $em->persist($passager);
    }

    // Vérifier et créer "Chauffeur" si nécessaire
    $chauffeur = $profilRepo->findOneBy(['libelle' => 'Chauffeur']);
    if (!$chauffeur) {
      $chauffeur = new Profil();
      $chauffeur->setLibelle('Chauffeur');
      $em->persist($chauffeur);
    }

    // Sauvegarder les nouveaux profils si créés
    $em->flush();
  }

  /**
  * Enregistrement de la photo dans la base de donnée
  */
  #[Route('/user-space/photo', name: 'app_user_space_photo', methods: ['POST'])]
  public function uploadPhoto(Request $request, EntityManagerInterface $entityManager): JsonResponse
  {
    // Vérification token CSRF et authentification
    $data = json_decode($request->getContent(), true) ?? [];
    // fallback pour form post
    if (empty($data) && $request->request->has('_csrf_token')) {
        $data = $request->request->all();
    }
    $user = $this->verifySecurityAndGetUser($data, 'profile-photo');

    // 1. Récupérer ou créer les extras
    $extras = $user->getExtras();
    if (!$extras) {
      $extras = new UserExtras();
      $extras->setUser($user);
      $user->setExtras($extras);
      $entityManager->persist($extras);
      $entityManager->persist($user);
    }
    // 2. Récupération du fichier (multipart/form-data)
    $file = $request->files->get('photo');
    if (!$file) {
      return new JsonResponse(['success' => false, 'message' => 'No file provided'], 400);
    }
    // 3. Dossier de destination
    $uploadDir = $this->getParameter('kernel.project_dir') . '/public/uploads/users';
    // 4. Récupérer l’ancienne photo
    $oldPhoto = $extras->getPhoto();
    // 5. Générer un nom unique
    $filename = uniqid() . '.' . $file->guessExtension();
    // 6. Déplacer le fichier
    $file->move($uploadDir, $filename);
    // 7. Supprimer l’ancienne photo si elle existait
    if ($oldPhoto && file_exists($uploadDir . '/' . $oldPhoto)) {
      unlink($uploadDir . '/' . $oldPhoto);
    }
    // 8. Mettre à jour la photo dans les extras
    $extras->setPhoto($filename);
    // 9. Enregistrer en base de données
    $entityManager->flush();

    return new JsonResponse(['success' => true]);
  }

  /**
  * Mise à jour du profil utilisateur (chauffeur/passager)
  */
  #[Route('/user-space/profil', name: 'app_user_space_profil', methods: ['POST'])]
  public function updateProfil(Request $request, EntityManagerInterface $em): JsonResponse
  {
    // Vérification token CSRF et authentification
    $data = json_decode($request->getContent(), true) ?? [];
    // fallback pour form post
    if (empty($data) && $request->request->has('_csrf_token')) {
        $data = $request->request->all();
    }
    $user = $this->verifySecurityAndGetUser($data, 'profile-change');

    // S'assurer que les profils existent en base
    $this->ensureProfilsExist($em);

    // Récupération du profil choisi
    $profilValue = $data['profil'] ?? 'Passager';
    $profilRepo = $em->getRepository(Profil::class);

    // vider existants
    foreach ($user->getProfils() as $p) {
      $user->removeProfil($p);
    }

    // Si 'les2', ajouter les deux profils
    if ($profilValue === 'les2') {
      $p1 = $profilRepo->findOneBy(['libelle' => 'Passager']);
      $p2 = $profilRepo->findOneBy(['libelle' => 'Chauffeur']);
      if ($p1) $user->addProfil($p1);
      if ($p2) $user->addProfil($p2);
    } else {
      // Sinon, ajouter le profil choisi
      $label = ucfirst($profilValue); // 'passager' -> 'Passager'
      $p = $profilRepo->findOneBy(['libelle' => $label]);
      if ($p) $user->addProfil($p);
    }

    $em->persist($user);
    $em->flush();

    return new JsonResponse(['success' => true]);
  }

  /**
  * Mise a jour des préférences utilisateur
  */
  #[Route('/user-space/preferences', name: 'app_user_space_preferences', methods: ['POST'])]
  public function updatePreferences(Request $request, EntityManagerInterface $em): JsonResponse
  {
    // Vérification token CSRF et authentification
    $data = json_decode($request->getContent(), true) ?? [];
    // fallback pour form post
    if (empty($data) && $request->request->has('_csrf_token')) {
        $data = $request->request->all();
    }
    $user = $this->verifySecurityAndGetUser($data, 'profile-change');

    // Récupérer ou créer les préférences
    $preferences = $user->getPreferences();
    if (!$preferences) {
      $preferences = new Preferences();
      $user->setPreferences($preferences);
      $em->persist($preferences);
    }

    // Mettre à jour les préférences
    $preferences->setFumeur(isset($data['fumeur']) && $data['fumeur'] === 'fumeur');
    $preferences->setAnimal(isset($data['animaux']) && $data['animaux'] === 'animaux');
    $preferences->setPerso($data['preferences'] ?? '');

    $em->persist($user);
    $em->flush();

    return new JsonResponse(['success' => true]);
  }

  /**
  * Mise a jour des informations utilisateur
  */
  #[Route('/user-space/infos', name: 'app_edit_info_process', methods: ['POST'])]
  public function updateInfos(Request $request, EntityManagerInterface $em): JsonResponse
  {
    try {
      // Vérification token CSRF et authentification
      $data = json_decode($request->getContent(), true) ?? [];
      // fallback pour form post
      if (empty($data) && $request->request->has('_csrf_token')) {
          $data = $request->request->all();
      }
      $user = $this->verifySecurityAndGetUser($data, 'infos-change');

      // Récupérer les nouvelles informations
      $newPseudo = $data['pseudo'] ?? null;
      $newEmail = $data['email'] ?? null;
      $oldPassword = $data['oldPassword'] ?? null;
      $newPassword = $data['newPassword'] ?? null;

      // Vérifier si le nouveau pseudo n'existe pas déjà
      if ($newPseudo !== null && $newPseudo !== $user->getPseudo()) {
          $existingUser = $em->getRepository(User::class)->findOneBy(['pseudo' => $newPseudo]);
          if ($existingUser) {
              return new JsonResponse(['success' => false, 'message' => 'Ce pseudo existe déjà'], 409);
          }
      }
      // Si un nouveau mot de passe est fourni, vérifier l'ancien mot de passe
      if (!empty($newPassword)) {
          if (empty($oldPassword)) {
              return new JsonResponse(['success' => false, 'message' => 'Ancien mot de passe requis'], 400);
          }
          // Vérifier que l'ancien mot de passe correspond au hash enregistré
          if (!$this->hasher->isPasswordValid($user, $oldPassword)) {
              return new JsonResponse(['success' => false, 'message' => 'Ancien mot de passe incorrect'], 401);
          }
          // Hasher et enregistrer le nouveau mot de passe
          $user->setPassword($this->hasher->hashPassword($user, $newPassword));
      }

      if ($newPseudo !== null) {
          $user->setPseudo($newPseudo);
      }
      if ($newEmail !== null) {
          $user->setEmail($newEmail);
      }

      $em->persist($user);
      $em->flush();

      return new JsonResponse([
        'success' => true,
        // URL de rafraîchissement de la page
        'redirect' => $this->generateUrl('app_user_space'),
      ]);
    } catch (AccessDeniedHttpException $e) {
      return new JsonResponse(['success' => false, 'message' => 'Token CSRF invalide'], 403);
    } catch (\Exception $e) {
      return new JsonResponse(['success' => false, 'message' => 'Erreur serveur: ' . $e->getMessage()], 500);
    }
  }

  /**
  * Affichage de l'espace utilisateur
  */
  #[Route('/user-space', name: 'app_user_space')]
  public function index(EntityManagerInterface $em): Response
  {
    // Récupération de l'utilisateur connecté et de ses extras
    $user = $this->getUser();
    if (!$user) {
      return $this->redirectToRoute('app_login');
    }

    // S'assurer que les profils existent en base
    $this->ensureProfilsExist($em);

    $extras = $user?->getExtras();
    $profils = $user->getProfils();
    $preferences = $user->getPreferences();

    // Déterminer le profil sélectionné ; si vide, mettre "Passager" par défaut et persister
    $selectedProfil = 'passager';

    if ($profils->isEmpty()) {
      $profilRepo = $em->getRepository(Profil::class);
      $passager = $profilRepo->findOneBy(['libelle' => 'Passager']);
      if ($passager) {
        $user->addProfil($passager);
        $em->persist($user);
        $em->flush();
      }
      $selectedProfil = 'passager';
    } else {
      // construire liste de libellés existants
      $labels = array_map(fn($p) => $p->getLibelle(), $profils->toArray());
      $hasPass = in_array('Passager', $labels, true);
      $hasChauf = in_array('Chauffeur', $labels, true);

      if ($hasPass && $hasChauf) {
        $selectedProfil = 'les2';
      } elseif ($hasChauf) {
        $selectedProfil = 'chauffeur';
      } else {
        $selectedProfil = 'passager';
      }
    }

    // Récupération des informations de l'utilisateur
    $pseudo = $user?->getPseudo() ?? 'Utilisateur';
    $email = $user?->getEmail() ?? '';
    $photo = $extras?->getPhoto() ?? '';
    $credit = $extras?->getCredit();
    $note = $extras?->getNote();
    $hasFumeur = $preferences?->isFumeur() ?? false;
    $hasAnimaux = $preferences?->isAnimal() ?? false;
    $autresPreferences = $preferences?->getPerso() ?? '';

    // Récupérer les véhicules de l'utilisateur pour l'affichage
    $voitures = $this->vehiculeInfoService->getVoituresInfosByUser($user);

    return $this->render('pages/espaces/user-space.html.twig', [
      'userName' => $pseudo,
      'userPhoto' => $photo,
      'userCredit' => $credit,
      'userNote' => $note,
      'userEmail' => $email,
      'selectedProfil' => $selectedProfil,
      'hasFumeur' => $hasFumeur,
      'hasAnimaux' => $hasAnimaux,
      'autresPreferences' => $autresPreferences,
      'voitures' => $voitures,
    ]);
  }

  /**
  * Suppression du compte utilisateur
  */
  #[Route('/user-space/supprimer-compte', name: 'app_user_space_delete_account', methods: ['POST'])]
  public function deleteAccount(Request $request, EntityManagerInterface $em): Response
  {
    // Vérification token CSRF et authentification
    $data = json_decode($request->getContent(), true) ?? [];
    // fallback pour form post
    if (empty($data) && $request->request->has('_csrf_token')) {
        $data = $request->request->all();
    }
    $user = $this->verifySecurityAndGetUser($data, 'delete-account');

    // 1. Récupérer ou créer les extras
    $extras = $user->getExtras();
    if (!$extras) {
      $extras = new UserExtras();
      $extras->setUser($user);
      $user->setExtras($extras);
      $em->persist($extras);
      $em->persist($user);
    }
    // 3. Dossier de destination
    $uploadDir = $this->getParameter('kernel.project_dir') . '/public/uploads/users';
    // 4. Récupérer la photo
    $photo = $extras->getPhoto();
    // 5. Supprimer la photo si elle existait
    if ($photo && file_exists($uploadDir . '/' . $photo)) {
        unlink($uploadDir . '/' . $photo);
    }

    // Supprimer l'utilisateur
    $em->remove($user);
    $em->flush();

    // Déconnecter l'utilisateur après la suppression
    $this->container->get('security.token_storage')->setToken(null);
    $request->getSession()->invalidate();

    // Redirection vers la page d'accueil
    return $this->redirectToRoute('app_home');
  }

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
