<?php 

namespace App\Controller\Stash;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class StashController extends AbstractController
{
    #[Route('/stash', name: 'stash')]
    public function open(): Response
    {
        #TODO 
        // логика формирования стеша игрока 


        return $this->render('stash/index.html.twig', [
            'items' => [],
        ]);
    }
}    