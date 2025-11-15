<?php

namespace App\Controller\espaces;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserVehicleController extends AbstractController
{
  #[Route('/user-vehicle', name: 'app_user_vehicle')]
  public function index(): Response
  {
    return $this->render('pages/espaces/user-vehicle.html.twig');
  }
}
