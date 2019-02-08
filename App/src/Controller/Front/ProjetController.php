<?php
/**
 * Created by PhpStorm.
 * User: Tounsi
 * Date: 27/01/2019
 * Time: 16:12
 */

namespace App\Controller\Front;


use App\Repository\ProjetRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Projet;


class ProjetController extends AbstractController
{

    /**
     * @var ObjectManager
     * @var ProjetRepository
     */
    private $em;
    private $repository;

    public function __construct(ProjetRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @param ProjetRepository $repository
     * @return Response
     * @Route(name="projet_front", path="/index", methods={"GET"})
     */
    public function index($repository): Response
    {
        $projets = $repository->findLatest();
        return $this->render('Front/Projet/index.html.twig', [
            'projets' => $projets
        ]);
    }
    /**
     * @param ProjetRepository $repository
     * @return Response
     *
     * @Route(name="projet_index", path="/projets")
     */
    public function show_projets(ProjetRepository $repository): Response
    {
        $projets = $repository->findLatest();
        return $this->render('Front/Projet/index.html.twig', [
            'projets' => $projets
        ]);
    }
    /**
     * @return Response
     * @Route(name="projet_show", path="/projets/{slug}-{id}", methods={"GET"}, requirements={"slug": "[a-z0-9\-]*"})
     */
    public function show(Projet $projet, string $slug): Response
    {
        if($projet->getSlug() !== $slug){
            return $this->redirectToRoute('projet_show', [
                'id' => $projet->getId(),
                'slug' => $projet->getSlug()
            ], 301);
        }
        return $this->render('Front/Projet/show.html.twig', [
            'projet' => $projet,
            'current_menu' => 'projets'
        ]);

    }

}