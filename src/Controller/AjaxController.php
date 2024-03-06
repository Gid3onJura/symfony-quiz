<?php

namespace App\Controller;

use App\Entity\Users;
use App\Service\Utilities;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AjaxController extends AbstractController
{
    #[Route('/ajax/checkregistration')]
    public function checkregistration(Request $request, EntityManagerInterface $em, Utilities $utilities): Response
    {
        $session = new Session();
        $sNickname = '';
        $sAccessCode = '';
        $sUserEmail = '';
        $sAccessCodeFromSession = '';

        // if (!empty($session)) {
        //     $sAccessCodeFromSession = $session->get('accesscode');
        // }

        $sNickname = $request->get('inputNickname') ?? '';
        $sUserEmail = $request->get('inputUserEmail') ?? '';

        // check if nickname already exists
        $oUser = $em->getRepository(Users::class)->findBy(array('nickname' => $sNickname));

        if (!empty($oUser)) {
            return new JsonResponse([
                'message' => "Dein Nickname ist bereits vergeben. Bitte gib einen anderen Namen ein.",
                'status' => 400
            ]);
        }

        return new JsonResponse(true);
    }

    #[Route('/ajax/register', methods: ['POST'])]
    public function registeruser(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager, Utilities $utilities): Response
    {
        $session = new Session();
        $sNickname = '';
        $sUserEmail = '';
        $iAttempts = 0;

        $sNickname = $request->get('inputNickname') ?? '';
        $sUserEmail = $request->get('inputUserEmail') ?? '';

        // create a random string
        $sAccessCode = $utilities->generateRandomCode();

        // check if code already exists
        $oUser = $entityManager->getRepository(Users::class)->findBy(array('code' => $sAccessCode));

        $iMaxAttempts = pow(6, 62);

        while (!empty($oUser)) {
            if ($iAttempts >= pow(6, 62)) {
                $sAccessCode = $utilities->generateRandomCode(7);
            } else {
                $sAccessCode = $utilities->generateRandomCode();
            }
            $oUser = $entityManager->getRepository(Users::class)->findBy(array('code' => $sAccessCode));
            $iAttempts++;
        }

        try {
            $oUser = new Users();

            // hash the password (based on the security.yaml config for the $user class)
            $hashedPassword = $passwordHasher->hashPassword(
                $oUser,
                $sAccessCode
            );

            $oUser->setPassword($hashedPassword);
            $oUser->setNickname($sNickname);
            $oUser->setEmail($sUserEmail);
            $oUser->setActive(true);
            $oUser->setCreatedat(new DateTimeImmutable());
            $oUser->setRoles(array('ROLE_USER'));

            $entityManager->persist($oUser);
            $entityManager->flush();
        } catch (\Exception $e) {
            dump($e);
            return new JsonResponse([
                'message' => "Etwas ist schiefgelaufen. Bitte versuche es später erneut.",
                'status' => 400
            ]);
        }

        return new JsonResponse([
            'accessCode' => $sAccessCode,
            'nickname' => $sNickname,
        ]);
    }
}
