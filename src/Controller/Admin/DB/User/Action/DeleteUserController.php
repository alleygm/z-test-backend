<?php 

namespace App\Controller\Admin\DB\User\Action;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DeleteUserController extends AbstractController
{
    public function __construct(private EntityManagerInterface $emi) {
    }

    #[Route('/admin/db/user/delete/{id}', name: 'admin_db_user_delete')]
    public function index(User $user): Response
    {
        // $this->emi->remove($user);

        return $this->render('admin/db/utils/delete_result.html.twig', [
        ]);
    }
}    