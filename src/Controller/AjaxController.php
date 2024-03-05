<?php

namespace App\Controller;

use App\Service\Utilities;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class AjaxController extends AbstractController
{
    #[Route('/ajax/checkregistration')]
    public function checkregistratio (Request $request, Utilities $utilities): Response
    {
        $session = new Session();
        $sNickname = '';
        $sAccessCode = '';
        $sUserEmail = '';
        $sAccessCodeFromSession = '';

        if (!empty($session)) {
            $sAccessCodeFromSession = $session->get('accesscode');
        }

        $sNickname = $request->get('inputNickname') ?? '';
        $sAccessCode = $request->get('inputAccessCode')?? '';
        $sUserEmail = $request->get('inputUserEmail')?? '';

        if ($sAccessCodeFromSession != $sAccessCode) {
            return new JsonResponse([
                'message' => "Fehlerhafte Daten übertragen",
                'status' => 400
            ]);
        }

        return new JsonResponse(true);

    }
}