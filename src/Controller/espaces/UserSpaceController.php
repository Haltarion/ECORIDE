<?php

namespace App\Controller\espaces;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\UserExtras;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserSpaceController extends AbstractController
{
  // -------------------------
  // Affichage de l'espace utilisateur
  // -------------------------
  #[Route('/user-space', name: 'app_user_space')]
  public function index(): Response
  {
    // Récupération de l'utilisateur connecté et de ses extras
    $user = $this->getUser();
    $extras = $user?->getExtras();

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
    ]);
  }

  // -------------------------
  // Enregistrement de la photo dans la base de donnée
  // -------------------------
  #[Route('/user-space/photo', name: 'app_user_space_photo', methods: ['POST'])]
  public function uploadPhoto(Request $request, EntityManagerInterface $entityManager): Response
  {
    // Mettre à jour la photo de l'utilisateur dans la base de données
    $user = $this->getUser();
    if (!$user) {
      return $this->redirectToRoute('app_user_space');
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
}
