<?php

namespace App\Controller\covoiturage;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DetailVoyageController extends AbstractController
{
  #[Route('/detail-voyage', name: 'app_detail_voyage')]
  public function index(): Response
  {
    return $this->render('pages/covoiturage/detail-voyage.html.twig');
  }
}
