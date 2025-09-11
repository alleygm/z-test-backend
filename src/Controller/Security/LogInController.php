<?php

namespace App\Controller\Security;

use App\Form\Security\LoginFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

#[IsGranted('IS_AUTHENTICATED_FULLY')]
class LogInController extends AbstractController
{
    #[Route(path: '/login', name: 'login')]
    public function login(AuthenticationUtils $authenticationUtils, Request $request): Response
    {
         // Создаем форму
        $form = $this->createForm(LoginFormType::class);
        
        // Устанавливаем последнее введенное имя пользователя
        $form->get('username')->setData($authenticationUtils->getLastUsername());

        return $this->render('/security/login.html.twig', [
            'form' => $form->createView(),
            'error' => $authenticationUtils->getLastAuthenticationError(),
            'last_username' => $authenticationUtils->getLastUsername(),
        ]);
    }
}
