<?php
/**
 * Created by PhpStorm.
 * User: Tounsi
 * Date: 25/02/2019
 * Time: 16:12
 */

namespace App\Controller\Front\Back;


use App\Entity\Projet;
use App\Entity\User;
use App\Form\PostulerProjetType;
use App\Repository\ProjetRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


class DevisController extends AbstractController
{


}