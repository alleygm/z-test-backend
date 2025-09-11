<?php 

namespace App\Controller\Hideout;

use App\Interface\SessionServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class HideoutController extends AbstractController
{
    #[Route('/', name: 'hideout')]
    public function index(Request $request, SessionServiceInterface $ssi): Response
    {
        $session = $request->getSession();
        if(!$ssi->hasCharacter($session)){
            return $this->redirectToRoute('character_menu', [
                'id' => $this->getUser()->getId()
            ]);
        }

        return $this->render('hideout/hideout.html.twig', [
        ]);
    }
}    