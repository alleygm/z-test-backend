<?php 

namespace App\Controller\Admin\DB\User;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserProfileController extends AbstractController
{
    public function __construct(EntityManagerInterface $emi) {
    }
    #[Route('/admin/db/user/{id}', name: 'admin_db_user_profile')]
    public function index(User $user, int $id): Response
    {
        return $this->render('admin/db/user/user_profile.html.twig', [
            'item' => $user,
        ]);
    }
}    