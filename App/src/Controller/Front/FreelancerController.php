<?php

namespace App\Controller\Front;

use App\Entity\Freelancer;
use App\Repository\FreelancerRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FreelancerController extends AbstractController
{
    /**
     * @var ObjectManager
     * @var FreelancerRepository
     */
    private $em;
    private $repository;

    public function __construct(FreelancerRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }
    /**
     * @Route("/freelancer", name="freelancer")
     */
    public function index()
    {
        return $this->render('Front/freelancer/index.html.twig', [
            'controller_name' => 'freelancer',
        ]);
    }

    /**
     * @param FreelancerRepository $repository
     * @return Response
     *
     * @Route(name="freelancer_index", path="/freelancers")
     */
    /*public function show_freelancers(FreelancerRepository $repository): Response
    {
        $freelancs = $repository->findLatest();
        return $this->render('Front/freelancer/index.html.twig', [
            'freelancs' => $freelancs
        ]);
    }

*/


    /**
     * @param Freelancer $freelancer
     * @param string $slug
     * @return Response
     * @Route(name="freelancer_show", path="/freelancers/{slug}-{id}", methods={"GET"}, requirements={"slug": "[a-z0-9\-]*"})
     */
    /*public function show(Freelancer $freelancer, string $slug): Response
    {
        if($freelancer->getSlug() !== $slug){
            return $this->redirectToRoute('freelancer_show', [
                'id' => $freelancer->getId(),
                'slug' => $freelancer->getSlug()
            ], 301);
        }
        return $this->render('Front/Projet/show.html.twig', [
            'projet' => $freelancer,
            'current_menu' => 'projets'
        ]);

    }*/
}
