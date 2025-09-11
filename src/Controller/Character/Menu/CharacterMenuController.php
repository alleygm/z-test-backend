<?php 

namespace App\Controller\Character\Menu;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class CharacterMenuController extends AbstractController
{
    #[Route('/character/menu', name: 'character_menu')]
    public function index(Request $request): Response
    {
        return $this->render('character/menu/index.html.twig', [
            "characters" => $this->getUser()->getCharacters()->getValues(),
        ]);
    }
}    