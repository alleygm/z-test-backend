<?php 

namespace App\Service;

use App\Interface\SessionServiceInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class SessionService implements SessionServiceInterface
{
    /**
     * @param \Symfony\Component\HttpFoundation\Session\SessionInterface $session
     * @return bool
     */
    public function hasCharacter(SessionInterface $session): bool
    {
        return $session->has('character');
    }
}    