<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SuggestTripController extends AbstractController
{
  #[Route('/suggest-trip', name: 'app_suggest_trip')]
  public function index(): Response
  {
    return $this->render('pages/espaces/suggest-trip.html.twig');
  }
}
