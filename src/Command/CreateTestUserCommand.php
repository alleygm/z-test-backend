<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(name: 'app:user:create-test')]
class CreateTestUserCommand
{
    public function __construct(private UserPasswordHasherInterface $userPasswordHasher, private EntityManagerInterface $entityManager) {
    }
    public function __invoke(OutputInterface $output, ): int
    {

        $user = new User();
        $email = "user@user.ru";
        $pwd = "password";

        $user->setEmail($email);
        $user->setPassword($this->userPasswordHasher->hashPassword($user, $pwd));

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return Command::SUCCESS;
    }
}