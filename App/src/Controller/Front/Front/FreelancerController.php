<?php

namespace App\Controller\Front\Front;

use App\Entity\User;
use App\Form\FreelancerSearchType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Asset\Package;
use Doctrine\ORM\Tools\Pagination\Paginator;
use App\Repository\UserRepository;
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
   /* public function index(Request $request, UserRepository $userRepository, PaginatorInterface $paginator): Response

    {
        $users = $paginator->paginate(
            $this-> repository->findAllVisibleQuery(),
            $request->query->getInt('page', 1),
            3/*limit per page*/
       /* );
        return $this->render('Front/Freelancer/showFree.html.twig', [
            'users' => $users,
        ]);
    }*/

    /**
     * @Route("/freelancer", name="free_index", methods={"GET"})
     * @param UserRepository $userRepository
     * @param Request $request
     * @return Response
     */
    public function indexFree(UserRepository $userRepository, Request $request): Response
    {
        $search = new User();
        $form = $this->createForm(FreelancerSearchType::class, $search);
        $form->handleRequest($request);

        dump($search);
        if($form->isSubmitted() && $form->isValid()){
            $freelancers = $userRepository->findFreelancers($search);
            //dump($freelancers);
            return $this->render('Front/freelancer/ShowFree.html.twig', [
                'users'   => $freelancers,
                'form'          => $form->createView()
            ]);
        }

        $freelancers = $userRepository->findLatest();
        return $this->render('Front/freelancer/ShowFree.html.twig', [
            'users'       => $freelancers,
            'form'              => $form->createView(),
            'controller_name'   => 'freelancer',
        ]);
    }

    /**
     * @param User $user
     * @param string $slug
     * @return Response
     * @Route(name="user_show", path="/users/{slug}-{id}", methods={"GET"}, requirements={"slug": "[a-z0-9\-]*"})
     */
    public function show_user(User $user, string $slug): Response
    {
        if($user->getSlug() !== $slug){
            return $this->redirectToRoute('user_show', [
                'id' => $user->getId(),
                'slug' => $user->getSlug()
            ], 301);
        }
        return $this->render('Front/freelancer/show.html.twig', [
            'user' => $user,
            'current_menu' => 'users'
        ]);
    }

}
