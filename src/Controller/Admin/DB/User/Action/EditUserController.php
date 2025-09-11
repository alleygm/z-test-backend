<?php 

namespace App\Controller\Admin\DB\User\Action;

use App\Entity\User;
use App\Form\Admin\UserEditFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EditUserController extends AbstractController
{
    public function __construct(EntityManagerInterface $emi) {
    }
    #[Route('/admin/db/user/edit/{id}', name: 'admin_db_user_edit')]
    public function index(User $user, Request $request): Response
    {

        $form = $this->createForm(UserEditFormType::class, $user, []);
        $form->handleRequest($request);
        if($form->isSubmitted())
        {
            if($form->isValid())
            {

            }
        }
        return $this->render('admin/db/user/user_edit_form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}    