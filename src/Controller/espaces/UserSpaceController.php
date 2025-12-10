<?php

namespace App\Controller\espaces;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Entity\UserExtras;
use App\Entity\Profil;
use App\Entity\Preferences;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Security\CsrfTokenVerifier;

class UserSpaceController extends AbstractController
{
  private CsrfTokenVerifier $csrfVerifier;

  public function __construct(CsrfTokenVerifier $csrfVerifier)
  {
    $this->csrfVerifier = $csrfVerifier;
  }

  // -------------------------
  // Enregistrement de la photo dans la base de donnée
  // -------------------------
  #[Route('/user-space/photo', name: 'app_user_space_photo', methods: ['POST'])]
  public function uploadPhoto(Request $request, EntityManagerInterface $entityManager): Response
  {
    // Vérification du token CSRF
    $data = json_decode($request->getContent(), true) ?? [];
    // lance AccessDeniedHttpException si invalide
    $this->csrfVerifier->assertTokenValid('profile-change', $data['_csrf_token'] ?? '');

    // Mettre à jour la photo de l'utilisateur dans la base de données
    $user = $this->getUser();
    if (!$user) {
      return new JsonResponse(['success' => false, 'message' => 'Not authenticated'], 401);
    }

    // 1. Récupérer ou créer les extras
    $extras = $user->getExtras();
    if (!$extras) {
      $extras = new UserExtras();
      $extras->setUser($user);
      $user->setExtras($extras);
      $entityManager->persist($extras);
      $entityManager->persist($user);
    }
    // 2. Récupération du fichier
    $file = $request->files->get('photo');
    if (!$file) {
      // rien envoyé → on sort
      return $this->redirectToRoute('app_user_space');
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

    return $this->redirectToRoute('app_user_space');
  }
  // -------------------------
  // Mise à jour du profil utilisateur (chauffeur/passager)
  // -------------------------
  #[Route('/user-space/profil', name: 'app_user_space_profil', methods: ['POST'])]
  public function updateProfil(Request $request, EntityManagerInterface $em): JsonResponse
  {
    // Vérification du token CSRF
    $data = json_decode($request->getContent(), true) ?? [];
    // lance AccessDeniedHttpException si invalide
    $this->csrfVerifier->assertTokenValid('profile-change', $data['_csrf_token'] ?? '');

    // Récupération du profil choisi
    $profilValue = $data['profil'] ?? 'Passager';
    $user = $this->getUser();
    if (!$user) {
      return new JsonResponse(['success' => false, 'message' => 'Not authenticated'], 401);
    }

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

  // -------------------------
  // Mise a jour des préférences utilisateur
  // -------------------------
  #[Route('/user-space/preferences', name: 'app_user_space_preferences', methods: ['POST'])]
  public function updatePreferences(Request $request, EntityManagerInterface $em): JsonResponse
  {
    // Vérification du token CSRF
    $data = json_decode($request->getContent(), true) ?? [];
    // lance AccessDeniedHttpException si invalide
    $this->csrfVerifier->assertTokenValid('profile-change', $data['_csrf_token'] ?? '');
  }

  // -------------------------
  // Affichage de l'espace utilisateur
  // -------------------------
  #[Route('/user-space', name: 'app_user_space')]
  public function index(EntityManagerInterface $em): Response
  {
    // Récupération de l'utilisateur connecté et de ses extras
    $user = $this->getUser();
    if (!$user) {
      return $this->redirectToRoute('app_login');
    }
    $extras = $user?->getExtras();
    $profils = $user->getProfils();

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
    $photo = $extras?->getPhoto() ?? '';
    $credit = $extras?->getCredit();
    $note = $extras?->getNote();


    return $this->render('pages/espaces/user-space.html.twig', [
      'userName' => $pseudo,
      'userPhoto' => $photo,
      'userCredit' => $credit,
      'userNote' => $note,
      'selectedProfil' => $selectedProfil,
    ]);
  }
}
