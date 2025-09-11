<?php 

namespace App\Controller\Activities\Mine;

use App\Interface\SessionServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class MineController extends AbstractController
{
    #[Route('/activities/mine', name: 'activities_mine')]
    public function index(Request $request, SessionServiceInterface $ssi): Response
    {

        return $this->render('activities/mine/index.html.twig', [
        ]);
    }
}    