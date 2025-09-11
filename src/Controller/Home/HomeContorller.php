<?php

namespace App\Controller\Home;

use App\Form\Security\LoginFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

#[IsGranted('ROLE_USER')]
class HomeContorller extends AbstractController
{
    #[Route(path: '/', name: 'home')]
    public function index(): Response
    {
        return $this->render('/home/index.html.twig', [
        ]);
    }
}
