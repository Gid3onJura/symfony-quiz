<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndexController extends AbstractController
{
    #[Route('/' , name:'app_index')]
    public function index(): Response
    {
        $aTemplateData = array();

        return $this->render('index/index.html.twig', $aTemplateData);
    }
}