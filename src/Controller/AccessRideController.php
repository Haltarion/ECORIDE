<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccessRideController extends AbstractController
{
  #[Route('/access-ride', name: 'app_access_ride')]
  public function index() : Response
  {
    return $this->render('pages/covoiturage/access-ride.html.twig');
  }
}