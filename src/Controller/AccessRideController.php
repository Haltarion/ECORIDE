<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccessRideController extends AbstractController
{
  #[Route('/access-ride', name: 'app_access_ride', methods: ['POST'])]
  public function index(Request $request): Response
  {
    $adresseDepart = $request->request->get('adresseDepart');
    $adresseArrivee = $request->request->get('adresseArrivee');
    $dateDepart = $request->request->get('dateDepart');
    $dateArrivee = $request->request->get('dateArrivee');

    // Pour l'instant, on simule une recherche
    // Plus tard je pourrais interroger ma base de données ici

    return $this->render('pages/covoiturage/access-ride.html.twig', [
      'adresseDepart' => $adresseDepart,
      'adresseArrivee' => $adresseArrivee,
      'dateDepart' => $dateDepart,
      'dateArrivee' => $dateArrivee,
    ]);
  }
}
