<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ModifVehicleController extends AbstractController
{
  #[Route('/modif-vehicle', name: 'app_modif_vehicle')]
  public function index(): Response
  {
    return $this->render('pages/espaces/modif-vehicle.html.twig');
  }
}
