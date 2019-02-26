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
   public function index(Request $request, UserRepository $userRepository, PaginatorInterface $paginator): Response
    {
        $search = new User();
        $form = $this->createForm(FreelancerSearchType::class, $search);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $freelancers = $userRepository->findFreelancers($search);
            return $this->render('Front/freelancer/index.html.twig', [
                'freelancers'         => $freelancers,
                'form'          => $form->createView()
            ]);
        }
      
        $users = $paginator->paginate(
            $this-> repository->findAllVisibleQuery(),
            $request->query->getInt('page', 1),
            3/*limit per page*/
        );
        return $this->render('Front/Freelancer/index.html.twig', [
            'freelancers' => $users,
            'form'  => $form->createView(),
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
