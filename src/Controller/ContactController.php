<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
  #[Route('/contact',name:'app_contact')]
  public function index() : Response
  {
    return $this->render('pages/contact.html.twig');
  }
}