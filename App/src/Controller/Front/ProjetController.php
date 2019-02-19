<?php
/**
 * Created by PhpStorm.
 * User: Tounsi
 * Date: 27/01/2019
 * Time: 16:12
 */

namespace App\Controller\Front;


use App\Form\ProjetSearchType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Asset\Package;
use Symfony\Component\Asset\VersionStrategy\EmptyVersionStrategy;
use App\Repository\ProjetRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     * @param Request $request
     * @param ProjetRepository $repository
     * @param PaginatorInterface $paginator
     * @return Response
     * @Route(name="projet_index", path="/projets", methods={"GET"})
     */

    public function index(Request $request, ProjetRepository $repository, PaginatorInterface $paginator): Response
    {
        $search = new Projet();
        $form = $this->createForm(ProjetSearchType::class, $search);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $projets = $paginator->paginate(
                $this->repository->findProjects($search),
                $request->query->getInt('page', 1),
                3/*limit per page*/
            );

            return $this->render('Front/Projet/index.html.twig', [
                'projets'   => $projets,
                'form'      => $form->createView()
            ]);
        }

        $projets = $paginator->paginate(
            $this->repository->findAllVisibleQuery(),
            $request->query->getInt('page', 1),
            3/*limit per page*/
        );
        return $this->render('Front/Projet/index.html.twig', [
            'projets' => $projets,
            'form'    => $form->createView()
        ]);
    }

    /**
     * @param Projet $projet
     * @param string $slug
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