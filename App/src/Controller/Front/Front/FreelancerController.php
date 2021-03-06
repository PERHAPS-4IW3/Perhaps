<?php
namespace App\Controller\Front\Front;

use App\Entity\User;
use App\Entity\UserSearch;
use App\Form\FreelancerSearchType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Asset\Package;
use Doctrine\ORM\Tools\Pagination\Paginator;
use App\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


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
     * @param PaginatorInterface $paginator
     * @return Response
     */
   public function index(Request $request, PaginatorInterface $paginator): Response
    {
        $search = new UserSearch();
        $form = $this->createForm(FreelancerSearchType::class, $search);
        $form->handleRequest($request);

        $freelancers = $paginator->paginate(
            $this->repository->findFreelancers($search),
            $request->query->getInt('page', 1),
            9/*limit per page*/
            );

        return $this->render('Front/freelancer/index.html.twig', [
            'freelancers'   => $freelancers,
            'form'      => $form->createView()
        ]);
    }

    public function getFreelancer($id = null){
       $freelancer = $this->repository->find($id);

       return $this->json($freelancer->getNomUser());
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

    /**
     * @Route("/freelancer/API", name="free_api", methods={"GET"})
     * @return Response
     */
    public function getAllFreelancer(){

        $freelancers = $this->repository->findVisibleAllFreelancerQueryAPI();

        $response = new Response(json_encode($freelancers));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

}
