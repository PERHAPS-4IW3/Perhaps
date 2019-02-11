<?php
/**
 * Created by PhpStorm.
 * User: Tounsi
 * Date: 03/02/2019
 * Time: 00:15
 */

namespace App\Controller\Back;


use App\Entity\Freelancer;
use App\Form\ProjetType;
use App\Repository\FreelancerRepository;
use App\Repository\ProjetRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class FreelancerController extends AbstractController
{
    /**
     * @var FreelancerRepository
     */
    private $repository;

    /**
     * @var ObjectManager
     */
    private $em;

    /**
     * FreelancerController constructor.
     * @param FreelancerRepository $repository
     * @param ObjectManager $em
     */
    public function __construct(FreelancerRepository $repository, ObjectManager $em)
    {

        $this->repository = $repository;
        $this->em = $em;
    }
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route(name="user_freelancer_index", path="/user/freelancers", methods={"GET"})
     */
    public function index()
    {
        //récupérer tous les freelancer même si ils sont supprimés
        $projets = $this->repository->findAll();
        return $this->render('Back/Freelancer/index.html.twig', compact('freelancers'));
    }

    /**
     * @Route(name="user_freelancer_new", path="/user/freelancers/new", methods={"GET", "POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function new(Request $request)
    {
        $freelancer = new Freelancer();
        $form = $this->createForm(ProjetType::class, $freelancer);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($freelancer);
            $this->em->flush();
            $this->addFlash('success', 'Le projet '. $freelancer->getNomFreelancer() .' a bien été ajouté');
            return $this->redirectToRoute('user_projet_index');
        }
        return $this->render('Back/Freelancer/new.html.twig', [
            'projet' => $freelancer,
            'form' => $form->createView()
        ]);

    }

}