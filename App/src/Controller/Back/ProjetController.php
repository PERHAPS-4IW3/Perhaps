<?php
/**
 * Created by PhpStorm.
 * User: Tounsi
 * Date: 03/02/2019
 * Time: 00:15
 */

namespace App\Controller\Back;


use App\Entity\Projet;
use App\Form\ProjetType;
use App\Repository\ProjetRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProjetController extends AbstractController
{
    /**
     * @var ProjetRepository
     */
    private $repository;

    /**
     * ProjetController constructor.
     * @param ProjetRepository $repository
     */
    public function __construct(ProjetRepository $repository)
    {

        $this->repository = $repository;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route(name="user_projet_index", path="/user/projets", methods={"GET"})
     */
    public function index()
    {
        //récupérer tous les projets même si ils sont supprimés
        $projets = $this->repository->findAll();
        return $this->render('Back/Projet/index.html.twig', compact('projets'));
    }

    /**
     * @Route(name="user_projet_edit", path="user/projets/{id}", methods={"GET"})
     * @param Projet $projet
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(Projet $projet)
    {
        $form = $this->createForm(ProjetType::class, $projet);
        return $this->render('Back/Projet/edit.html.twig', [
            'projet' => $projet,
            'form' => $form->createView()
        ]);
    }
}