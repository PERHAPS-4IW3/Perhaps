<?php

namespace App\Controller\Front;

use App\Entity\User;
use App\Form\FreelancerSearchType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Asset\Package;
use Doctrine\ORM\Tools\Pagination\Paginator;
use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FreelancerController extends AbstractController
{
    /**
     * @var ObjectManager
     * @var UserRepository
     */
    private $em;
    private $repository;

    public function __construct(UserRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @param Request $request
     * @Route("/freelancer", name="free_index", methods={"GET"})
     * @param UserRepository $userRepository
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function index(Request $request, UserRepository $userRepository, PaginatorInterface $paginator): Response
    {
        $search = new User();
        $form = $this->createForm(FreelancerSearchType::class, $search);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $freelancers = $userRepository->findFreelancers($search);
            return $this->render('Front/freelancer/showFree.html.twig', [
                'users'         => $freelancers,
                'form'          => $form->createView()
            ]);
        }
      
        $users = $paginator->paginate(
            $this-> repository->findAllVisibleQuery(),
            $request->query->getInt('page', 1),
            3/*limit per page*/
        );
        return $this->render('Front/Freelancer/showFree.html.twig', [
            'users' => $users,
            'form'  => $form->createView(),
        ]);
    }

    /**
     * @Route("/freelancer", name="freelancer")
     */
   /* public function index(UserRepository $repository, Request $request) :Response
    {
        $search = new User();
        $form = $this->createForm(FreelancerSearchType::class, $search);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $freelancers = $repository->findFreelancers($search);
            return $this->render('Front/freelancer/index.html.twig', [
                'freelancers'   => $freelancers,
                'form'          => $form->createView()
            ]);
        }

        $freelancers = $repository->findLatest();
        return $this->render('Front/freelancer/index.html.twig', [
            'freelancers'       => $freelancers,
            'form'              => $form->createView(),
            'controller_name'   => 'freelancer',
        ]);
    }*/

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
