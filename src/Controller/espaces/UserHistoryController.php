<?php

namespace App\Controller\espaces;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserHistoryController extends AbstractController
{
  #[Route('/user-history', name: 'app_user_history')]
  public function index(): Response
  {
    return $this->render('pages/espaces/user-history.html.twig');
  }
}
