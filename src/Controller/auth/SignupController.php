<?php

namespace App\Controller\auth;

use App\Entity\User;
use App\Entity\UserExtras;
use App\Entity\Profil;
use Symfony\Bundle\SecurityBundle\Security;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SignupController extends AbstractController
{
  // Route pour afficher le formulaire d'inscription (GET)
  #[Route('/signup', name: 'app_signup', methods: ['GET'])]
  public function signup(): Response
  {
    return $this->render('pages/auth/signup.html.twig');
  }

  // Route pour traiter l'inscription (POST)
  #[Route('/signup', name: 'app_signup_process', methods: ['POST'])]
  public function inscription(
    Request $request,
    EntityManagerInterface $em,
    UserPasswordHasherInterface $hasher,
    Security $security
  ): Response {
    $pseudo = $request->request->get('pseudo');
    $email = $request->request->get('email');
    $password = $request->request->get('password');

    if (!$pseudo || !$email || !$password) {
      return new JsonResponse(['success' => false, 'message' => 'Champs manquants'], 400);
    }

    // Création de l'utilisateur
    $user = new User();
    $user->setPseudo($pseudo);
    $user->setEmail($email);
    $user->setPassword($hasher->hashPassword($user, $password));

    // Créer les extras avec 20 crédits
    $extras = new UserExtras();
    $extras->setCredit('20');
    $extras->setNote('0.0');
    $extras->setUser($user);
    $user->setExtras($extras);

    // Ajouter les profils à l'utilisateur
    $profilRepository = $em->getRepository(Profil::class);
    $profilPassager = $profilRepository->findOneBy(['libelle' => 'Passager']);

    if ($profilPassager) {
      $user->addProfil($profilPassager);
    }

    $em->persist($user);
    $em->persist($extras);
    $em->flush();

    // Connexion automatique après inscription
    $security->login($user);

    return $this->redirectToRoute('app_user_space'); // Redirige vers la page mon compte après inscription
  }
}
