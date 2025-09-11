<?php

namespace App\Controller\Security;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AuthController extends AbstractController
{
    #[Route('/auth', name: 'auth')]
    public function index(): Response
    {
        return $this->render('security/auth.html.twig', [
            'controller_name' => 'Security/AuthController',
        ]);
    }
}
