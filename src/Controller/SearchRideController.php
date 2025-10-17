<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SearchRideController extends AbstractController
{
  #[Route('/search-ride', name: 'app_search_ride', methods:['GET','POST'])]
  public function searchRide(Request $request): Response
  {
    // Récupération de la ville d'arrivée depuis GET ou POST.
    // Use ->get() which reads from any parameter bag (query/post) and
    // provide null default so page loads even if not provided.
    $destinationArrivee = $request->get('destination', null);

    return $this->render('pages/search-ride.html.twig', [
      'destinationArrivee' => $destinationArrivee,
    ]);
  }
}