<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserSpaceController extends AbstractController
{
  #[Route('/user-space', name: 'app_user_space')]
  public function index(): Response
  {
    return $this->render('pages/espaces/user-space.html.twig');
  }
}
