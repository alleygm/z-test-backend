<?php 

namespace App\Controller\Admin\DB\User;

use App\Form\Admin\UserFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserListController extends AbstractController
{
    public function __construct(EntityManagerInterface $emi) {
    }

    #[Route('/admin/db/user', name: 'admin_db_user')]
    public function index(UserRepository $ur): Response
    {
        $users = $ur->findAll();

        $form = $this->createForm(UserFormType::class, null, []);
        return $this->render('admin/db/user/user_list.html.twig', [
            'form' => $form->createView(),
            'items' => $users,
        ]);
    }
}    