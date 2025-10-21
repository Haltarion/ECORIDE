<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CreatAccountController extends AbstractController
{
  #[Route('/creat-account',name:'app_creat_account')]
  public function index() : Response
  {
    return $this->render('pages/espaces/creat-account.html.twig');
  }
}