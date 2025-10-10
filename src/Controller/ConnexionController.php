<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ConnexionController extends AbstractController
{
  #[Route('/connexion',name:'app_connexion')]
  public function index() : Response
  {
    return $this->render('pages/connexion.html.twig');
  }
}