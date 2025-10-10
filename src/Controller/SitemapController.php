<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SitemapController extends AbstractController
{
  #[Route('/sitemap',name:'app_sitemap')]
  public function index() : Response
  {
    return $this->render('pages/sitemap.html.twig');
  }
}