<?php

namespace App\Controller\auth;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SignupController extends AbstractController
{
  #[Route('/signup', name: 'app_signup')]
  public function index(): Response
  {
    return $this->render('pages/auth/signup.html.twig');
  }
}
