<?php 

namespace App\Interface;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

Interface SessionServiceInterface{
    public function hasCharacter(SessionInterface $sessionInterface) : bool;
}