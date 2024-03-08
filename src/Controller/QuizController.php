<?php

namespace App\Controller;

use App\Entity\Users;
use App\Service\Utilities;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Doctrine\ORM\EntityManagerInterface;

class QuizController extends AbstractController
{
    #[Route('/quiz', name: 'app_quiz_index')]
    public function index(Utilities $utilities): Response
    {
        $aTemplateData = array();

        return $this->render('quiz/index.html.twig', $aTemplateData);
    }

    #[Route('/quiz/single', name: 'app_quiz_singleplayer')]
    public function singleplayer(Utilities $utilities): Response
    {
        $aTemplateData = array();

        return $this->render('quiz/singleplayer.html.twig', $aTemplateData);
    }

    #[Route('/quiz/multi', name: 'app_quiz_multiplayer')]
    public function multiplayer(Utilities $utilities): Response
    {
        $aTemplateData = array();

        return $this->render('quiz/multiplayer.html.twig', $aTemplateData);
    }
}
