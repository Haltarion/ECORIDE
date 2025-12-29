<?php

namespace App\Controller\covoiturage;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccessRideController extends AbstractController
{
  #[Route('/access-ride', name: 'app_access_ride', methods: ['POST'])]
  public function index(Request $request): Response
  {
    $adresseDepart = $request->request->get('adresseDepart', null);
    $adresseArrivee = $request->request->get('adresseArrivee', null);
    $dateDepart = $request->request->get('dateDepart', null);
    $dateArrivee = $request->request->get('dateArrivee', null);

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
