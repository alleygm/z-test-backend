<?php

namespace App\Controller\Character\Menu;

use App\Form\Character\CharacterCreateForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class CharacterCreateController extends AbstractController
{
    #[Route('/character/menu/create', name: 'character_menu_create')]
    public function index(Request $r, EntityManagerInterface $emi): Response
    {
        $form = $this->createForm(CharacterCreateForm::class, null, []);
        $form->handleRequest($r);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $char = $form->getData();
                $char->setUser($this->getUser());
                
                $emi->persist($char);
                $emi->flush();
                return $this->redirectToRoute('character_menu');
            }
        }
        return $this->render('character/menu/create.html.twig', [
            'form' => $form,
        ]);
    }
}