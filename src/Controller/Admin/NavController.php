<?php 

namespace App\Controller\Admin;

use App\Utilities\Admin\Nav;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class NavController extends AbstractController
{
    #[Route('/admin/nav', name: 'admin_nav')]
    public function Home(): Response
    {
        $response = [
            [   
                'title' => 'База данных',
                'options' => 
                [
                    [
                        'title' => 'Пользователи',
                        'url' => $this->generateUrl("admin_db_user")
                    ],
                    [
                        'title' => 'Пользователи',
                        'url' => ""
                    ],
                    [
                        'title' => 'Пользователи',
                        'url' => ""
                    ]
                ]
            ],

            [   
                'title' => 'Reserved',
                'options' => 
                [
                    [
                        'title' => 'Пользователи',
                        'url' => ""
                    ],
                    [
                        'title' => 'Пользователи',
                        'url' => ""
                    ],
                    [
                        'title' => 'Пользователи',
                        'url' => ""
                    ]
                ]
            ]
        ];
        return $this->render('admin/nav.html.twig', [
            'nav' => $response,
        ]);
    }
}    