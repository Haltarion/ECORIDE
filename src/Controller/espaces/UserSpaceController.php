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
  #[Route('/user-space', name: 'app_user_space')]
  public function index(): Response
  {
    $user = $this->getUser();
    $extras = $user?->getExtras();

    // Si l'utilisateur n'a pas encore d'extras → photo = ""
    $photo = $extras?->getPhoto() ?? '';
    return $this->render('pages/espaces/user-space.html.twig', [
      'userPhoto' => $photo,
    ]);
  }

  // Enregistrement de la photo dans la base de donnée
  #[Route('/user-space/photo', name: 'app_user_space_photo', methods: ['POST'])]
  public function uploadPhoto(Request $request, EntityManagerInterface $entityManager): Response
  {
    // Mettre à jour la photo de l'utilisateur dans la base de données
    $user = $this->getUser();

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

    // 4. Générer un nom unique
    $filename = uniqid() . '.' . $file->guessExtension();

    // 5. Déplacer le fichier
    $file->move($uploadDir, $filename);

    // 6. Mettre à jour la photo dans les extras
    $extras->setPhoto($filename);

    $entityManager->flush();

    return $this->redirectToRoute('app_user_space');
  }
}
