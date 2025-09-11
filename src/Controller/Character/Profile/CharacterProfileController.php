<?php 

namespace App\Controller\Character\Profile;

use App\Interface\SessionServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class CharacterProfileController extends AbstractController
{
    #[Route('/character/profile', name: 'character_profile')]
    public function index(Request $request, SessionServiceInterface $ssi): Response
    {
        $session = $request->getSession();
        if(!$ssi->hasCharacter($session)){
            return $this->redirectToRoute("character_menu");    
        }
        
        return $this->render('character/profile/index.html.twig', [
            "character" => $session->get('character'),
        ]);
    }
}    