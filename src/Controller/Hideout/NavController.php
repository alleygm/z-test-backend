<?php 

namespace App\Controller\Hideout;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class NavController extends AbstractController
{
    #[Route('/components/nav/character', name: 'hideout_nav')]
    public function index(): Response
    {
        $nav = [
            [   
                'title' => 'Персонаж',
                'options' => 
                [
                    [
                        'title' => 'Инвентарь',
                        'url' => $this->generateUrl('inventory'),
                        'turboFrame' => "right-side-frame"
                    ],
                    [
                        'title' => 'Профиль',
                        'url' => $this->generateUrl('character_profile'),
                        'turboFrame' => "left-side-frame"
                    ],
                    [
                        'title' => 'Хранилище',
                        'url' => $this->generateUrl('stash'),
                        'turboFrame' => "left-side-frame"
                    ],
                ]
            ],

            [   
                'title' => 'Активности',
                'options' => 
                [
                    [
                        'title' => 'Шахта',
                        'url' => "activities_mine"
                    ],
                    [
                        'title' => 'Шахта',
                        'url' => "activities_mine"
                    ],
                    [
                        'title' => 'Шахта',
                        'url' => "activities_mine"
                    ]
                ]
            ]
        ];

        return $this->render('hideout/nav.html.twig', [
            'nav' => $nav,
        ]);
    }
}    