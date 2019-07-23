<?php
/**
 * Created by PhpStorm.
 * User: Tounsi
 * Date: 27/01/2019
 * Time: 16:12
 */

namespace App\Controller\Front\Front;


use App\Entity\Devis;
use App\Entity\Equipe;
use App\Entity\User;
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
       // var_dump($projet);
        $devis = $projet->getListDevis()->getValues();
        $projets = $this->getDoctrine()->getManager()->getRepository(Projet::class)->findAll();
 
        $competences = $this->getDoctrine()->getManager()->getRepository(User::class)->findAll();
        $equipe = $this->getDoctrine()->getManager()->getRepository(Equipe::class)->findAll();

        $this->getDoctrine()->getManager()->persist($equipe[array_rand($equipe)]->addListParticipant($competences[array_rand($competences)]));

        $this->getDoctrine()->getManager()->flush();
        $var = $projet->getListDesEquipes()->first();

        foreach ($projet->getListDesEquipes() as $value) {
            foreach ($value->getListParticipants() as $valuex) {

                //var_dump($valuex );
            }
        }
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

    /**
     * @Route("/projet/API", name="projet_api", methods={"GET"})
     * @return Response
     */
    public function getAllFreelancer(){

        $freelancers = $this->repository->findAllProjectsAPI();

        $response = new Response(json_encode($freelancers));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }


}