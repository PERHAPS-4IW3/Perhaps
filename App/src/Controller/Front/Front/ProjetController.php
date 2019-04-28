<?php
/**
 * Created by PhpStorm.
 * User: Tounsi
 * Date: 27/01/2019
 * Time: 16:12
 */

namespace App\Controller\Front\Front;


use App\Entity\Equipe;
use App\Entity\User;
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
                9/*limit per page*/
            );

            return $this->render('Front/Projet/index.html.twig', [
                'projets'   => $projets,
                'form'      => $form->createView()
            ]);
        }

        $projets = $paginator->paginate(
            $this->repository->findAllVisibleQuery(),
            $request->query->getInt('page', 1),
            9/*limit per page*/
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

        $projets = $this->getDoctrine()->getManager()->getRepository(Projet::class)->findAll();
        $competences = $this->getDoctrine()->getManager()->getRepository(User::class)->findAll();
        $equipe = $this->getDoctrine()->getManager()->getRepository(Equipe::class)->findAll();

        //for($i = 0; $i <2; $i++){
      /*  $competenceProjet = (new Equipe())
            ->setIdProjet($projets[array_rand($projets)])
            ->setChefDeProjet($competences[array_rand($competences)])
            ->addListParticipant($competences[array_rand($competences)])
            ->addListParticipant($competences[array_rand($competences)])
            ->addListParticipant($competences[array_rand($competences)]);*/

       // var_dump($competenceProjet->getListParticipants()->first());
        $this->getDoctrine()->getManager()->persist($equipe[array_rand($equipe)]->addListParticipants($competences[array_rand($competences)]));

        // }
        $this->getDoctrine()->getManager()->flush();
       /* $t = $this->getDoctrine()->getRepository(Equipe::class)->findBy(['idProjet' => $projet->getId()] );
        $g = $t[0]->getListParticipants();
        $re = $this->getDoctrine()
            ->getRepository(Equipe::class)->toto($projet);
        var_dump($re );*/
      /*foreach ($t[0]->getListParticipants() as $valuex) {

            var_dump($valuex );
        }  $qb = $this->getDoctrine()->createQueryBuilder();
        // $idc = $this->getDoctrine()->createQueryBuilder();

        $qb = $this->getDoctrine()->getRepository()->createQueryBuilder()
            ->select('user')
            ->from(User::class, 'user')
            ->leftJoin(
                Equipe::class, 'i',
                Join::WITH, 'i.id = irc.ilot'
            )
            ->where('charge.quantity_at BETWEEN :start AND :end')
            ->orderBy('charge.quantity', 'ASC');

        $qb->setParameter('id_Pro', $projet->getId());

        return $qb->getQuery()->getResult();*/

        $var = $projet->getListDesEquipes()->first();

        foreach ($projet->getListDesEquipes() as $value) {
            foreach ($value->getListParticipants() as $valuex) {

                var_dump($valuex );
            }
        }
       // var_dump($var);
       // var_dump($var);
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