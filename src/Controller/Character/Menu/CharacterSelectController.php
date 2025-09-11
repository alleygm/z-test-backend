<?php 

namespace App\Controller\Character\Menu;

use App\Entity\Characters\Characters;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class CharacterSelectController extends AbstractController
{
    #[Route('/character/menu/select', name: 'character_menu_select')]
    public function index(Request $request, EntityManagerInterface $emi): Response
    {

        $charId = $request->query->get('id');
        if ($charId == null) {
            return $this->json("Отсутствует id персонажа");
        }

        $characterObj = $emi->getRepository(Characters::class)->find($charId);
        if (!$characterObj instanceof Characters) {
            return $this->json("Персонаж с id: $charId не найден в БД");
        }
            
        $session = $request->getSession();
        $session->set("character", $characterObj);

        return $this->redirectToRoute("hideout");
    }
}    