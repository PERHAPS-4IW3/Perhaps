<?php
/**
 * Created by PhpStorm.
 * User: Tounsi
 * Date: 03/02/2019
 * Time: 00:15
 */

namespace App\Controller\Back;


use App\Entity\Projet;
use App\Form\ProjetType;
use App\Repository\ProjetRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ProjetController extends AbstractController
{
    /**
     * @var ProjetRepository
     */
    private $repository;

    /**
     * @var ObjectManager
     */
    private $em;

    /**
     * ProjetController constructor.
     * @param ProjetRepository $repository
     * @param ObjectManager $em
     */
    public function __construct(ProjetRepository $repository, ObjectManager $em)
    {

        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route(name="user_projet_index", path="/user/projets", methods={"GET"})
     */
    public function index(User $user)
    {
        //récupérer tous les projets même si ils sont supprimés
        $projets = $this->repository->findAll();
        return $this->render('Back/Projet/index.html.twig', [
            'user'=> $user,
        ]);
    }

    /**
     * @Route(name="user_projet_new", path="/user/projets/new", methods={"GET", "POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function new(Request $request)
    {
        $projet = new Projet();
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($projet);
            $this->em->flush();
            $this->addFlash('success', 'Le projet '. $projet->getNomProjet() .' a bien été créé');
            return $this->redirectToRoute('user_projet_index');
        }
        return $this->render('Back/Projet/new.html.twig', [
            'projet' => $projet,
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route(name="user_projet_edit", path="user/projets/{id}", methods={"GET", "POST"})
     * @param Projet $projet
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(Projet $projet, Request $request)
    {
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->em->flush();
            $this->addFlash('success', 'Le projet '. $projet->getNomProjet() .' a bien été modifié');
            return $this->redirectToRoute('user_projet_index');
        }
        return $this->render('Back/Projet/edit.html.twig', [
            'projet' => $projet,
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Projet $projet
     * @Route(name="user_projet_delete", path="user/projets/delete/{id}", methods={"GET"})
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Request $request, Projet $projet): RedirectResponse
    {
        if (!$this->isCsrfTokenValid('delete-project', $request->query->get('_token'))) {
            throw new AccessDeniedException('Access Denied');
        }

        $this->em->remove($projet);
        $this->em->flush();
        $this->addFlash('success', 'Le projet '. $projet->getNomProjet() .' a bien été supprimé');
        return $this->redirectToRoute('user_projet_index');
    }
}