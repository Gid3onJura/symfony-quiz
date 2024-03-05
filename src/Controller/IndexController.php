<?php

namespace App\Controller;

use App\Service\Utilities;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class IndexController extends AbstractController
{
    #[Route('/' , name:'app_index')]
    public function index(Utilities $utilities): Response
    {
        $session = new Session();

        if (!empty($session)) {
            $session->start();
        }

        // generate a random string
        $sRandomCode = $utilities->generateRandomCode();

        // save the random string in the session
        if (!empty($sRandomCode)) {
            $session->set('accesscode', $sRandomCode);
        }

        $aTemplateData = array();

        return $this->render('index/index.html.twig', $aTemplateData);
    }

    #[Route('/register' , name:'app_register_user')]
    public function registeruser(Request $request, Utilities $utilities): Response
    {
        $session = new Session();
        $sNickname = '';
        $sUserEmail = '';
        $sAccessCodeFromSession = '';

        if (!empty($session)) {
            $sAccessCodeFromSession = $session->get('accesscode');
        }

        $sNickname = $request->get('inputNickname') ?? '';
        $sUserEmail = $request->get('inputUserEmail')?? '';

        $this->addFlash(
            'success',
            'Willkommen, du wurdest erfolgreich registriert.'
        );

        return $this->redirectToRoute('app_index');
    }
}