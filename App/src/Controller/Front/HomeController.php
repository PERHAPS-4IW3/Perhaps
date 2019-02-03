<?php
/**
 * Created by PhpStorm.
 * User: Tounsi
 * Date: 27/01/2019
 * Time: 12:36
 */

namespace App\Controller\Front;

use App\Repository\ProjetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    /**
     * @param ProjetRepository $repository
     * @return Response
     *
     * @Route(name="app_front_home", path="/")
     */
    public function home(ProjetRepository $repository): Response
    {
        $projets = $repository->findLatest();
        return $this->render('Front/Home/home.html.twig', [
            'projets' => $projets
        ]);
    }

}