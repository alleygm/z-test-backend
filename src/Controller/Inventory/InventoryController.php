<?php

namespace App\Controller\Inventory;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class InventoryController extends AbstractController
{
    #[Route('/inventory', name: 'inventory')]
    public function index(): Response
    {
        #TODO 
        // логика формирования инвентаря игрока 


        return $this->render('inventory/index.html.twig', [
            'items' => [],
        ]);
    }
}