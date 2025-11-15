<?php

namespace App\Controller\espaces;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
  #[Route('/admin', name: 'app_admin')]
  public function index(): Response
  {
    return $this->render('pages/espaces/admin.html.twig');
  }
}
