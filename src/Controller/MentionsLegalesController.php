<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MentionsLegalesController extends AbstractController
{
  #[Route('/mentions-legales', name: 'app_mentions_legales')]
  public function index(Request $request): Response
  {
    return $this->render('pages/mentions-legales.html.twig');
  }
}
