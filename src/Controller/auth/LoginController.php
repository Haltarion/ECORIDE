<?php

namespace App\Controller\auth;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LoginController extends AbstractController
{
  #[Route('/login', name: 'app_login')]
  public function index(): Response
  {
    return $this->render('pages/auth/login.html.twig');
  }
}
