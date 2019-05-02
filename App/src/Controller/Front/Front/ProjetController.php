<?php
/**
 * Created by PhpStorm.
 * User: Tounsi
 * Date: 27/01/2019
 * Time: 16:12
 */

namespace App\Controller\Front\Front;


use App\Entity\Devis;
use App\Form\ProjetSearchType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Asset\Package;
use Symfony\Component\Asset\VersionStrategy\EmptyVersionStrategy;
use App\Repository\ProjetRepository;
use App\Repository\DevisRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Projet;
use App\Entity\ProjetSearch;


class ProjetController extends AbstractController
{

    /**
     * @var ObjectManager
     * @var ProjetRepository
     * @var DevisRepository
     */
    private $em;
    private $repository;
    private $devisRepository;

    public function __construct(ProjetRepository $repository, ObjectManager $em , DevisRepository $devisRepository)
    {
        $this->repository = $repository;
        $this->devisRepository = $devisRepository;
        $this->em = $em;
    }

    /**
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     * @Route(name="projet_index", path="/projets", methods={"GET"})
     */

    public function index(Request $request, PaginatorInterface $paginator): Response
    {
        $search = new ProjetSearch();
        $form = $this->createForm(ProjetSearchType::class, $search);
        $form->handleRequest($request);

        $projets = $paginator->paginate(
            $this->repository->findProjects($search),
            $request->query->getInt('page', 1),
            9/*limit per page*/
        );

        return $this->render('Front/Projet/index.html.twig', [
            'projets'   => $projets,
            'form'      => $form->createView()
        ]);
    }

    /**
     * @param Projet $projet
     * @param string $slug
     * @return Response
     * @Route(name="projet_show", path="/projets/{slug}-{id}", methods={"GET", "POST"}, requirements={"slug": "[a-z0-9\-]*"})
     */
    public function show(Projet $projet, string $slug): Response
    {
        $devis = $projet->getListDevis()->getValues();

        //dump($devis);

        if($projet->getSlug() !== $slug){
            return $this->redirectToRoute('projet_show', [
                'id' => $projet->getId(),
                'slug' => $projet->getSlug(),
            ], 301);
        }
        return $this->render('Front/Projet/show.html.twig', [
            'projet' => $projet,
            'current_menu' => 'projets',
            'devis' => $devis,
        ]);

    }


}