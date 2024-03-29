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

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(Utilities $utilities): Response
    {
        $session = new Session();

        if (!empty($session)) {
            $session->start();
        }

        if ($this->getUser()) {
            return $this->redirectToRoute('app_quiz_index');
        }

        $aTemplateData = array();

        return $this->render('index/index.html.twig', $aTemplateData);
    }

    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_quiz_index');
        }
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        // $this->addFlash('error', 'Login Error');

        return $this->render('index/index.html.twig', [
            'controller_name' => 'LoginController',
            'last_username' => $lastUsername,
            'error' => $error,
            'showmodal' => 'authModal'
        ]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(AuthenticationUtils $authenticationUtils)
    {
    }
}
