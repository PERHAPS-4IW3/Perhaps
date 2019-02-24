<?php
/**
 * Created by PhpStorm.
 * User: Tounsi
 * Date: 07/02/2019
 * Time: 19:23
 */

namespace App\Controller\Front\Front;

use App\Entity\User as AppUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccountExpiredException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class UserChecker extends AbstractController implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user)
    {
        if (!$user instanceof AppUser) {
            return;
        }
    }

    /**
     * @param UserInterface $user
     * @return Response|void
     * @throws \Exception
     */
    public function checkPostAuth(UserInterface $user)
    {
        if (!$user instanceof AppUser) {
            return;
        }

        // user account is expired, the user may be notified
        if (!$user->getIsActive()) {
            throw new \Exception("Ce membre n'est pas actif");
        }

    }

}