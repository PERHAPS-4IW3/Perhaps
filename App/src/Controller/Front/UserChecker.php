<?php
/**
 * Created by PhpStorm.
 * User: Tounsi
 * Date: 07/02/2019
 * Time: 19:23
 */

namespace App\Controller\Front;

use App\Entity\User as AppUser;
use Symfony\Component\Security\Core\Exception\AccountExpiredException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;


class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user)
    {
        if (!$user instanceof AppUser) {
            return;
        }
    }

    /**
     * @param UserInterface $user
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