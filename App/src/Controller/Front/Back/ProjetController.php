<?php
/**
 * Created by PhpStorm.
 * User: Tounsi
 * Date: 03/02/2019
 * Time: 00:15
 */

namespace App\Controller\Front\Back;


use App\Entity\Equipe;
use App\Entity\NoteEtCommentaire;
use App\Entity\Projet;
use App\Entity\User;
use App\Entity\UserCollection;
use Symfony\Component\HttpFoundation\Response;
use App\Form\EquipeCollectionType;
use App\Form\NoteEtCommenaireType;
use App\Form\ProjetType;
use App\Form\TableNoteUserType;
use App\Form\UserCollectionType;
use App\Repository\ProjetRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use Symfony\Component\Serializer\Encoder\JsonEncoder;


/**
 * Class ProjetController
 *
 * @category  Class
 * @package   App\Controller\Front\Back
 * @Route("/Projet", name="")
 */

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
    public function index()
    {
        $user = $this->getUser();

        $projets = $this->repository->findProjectByUser($user);
        return $this->render('Back/Projet/index.html.twig', [
            'projets'=> $projets,
        ]);
    }

    /**
     * @Route(name="user_projet_new", path="/user/projets/new", methods={"GET", "POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function new(Request $request)
    {
        $user = $this->getUser();

        $projet = new Projet();
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);

        $projet->setCreePar($user);

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
     * @param Request $request
     * @param Projet $projet
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route(name="user_projet_delete", path="user/projets/delete/{id}", methods={"GET"})
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

    /**
     * @Route(name="user_projet_offers", path="user/projets/offers/{id}", methods={"GET", "POST"})
     * @param Projet $projet
     * @return Response
     */
    public function showOffers(Projet $projet): Response
    {
        $devis = $projet->getListDevis()->getValues();

        return $this->render('Back/Projet/Offers/showOffers.html.twig', [
            'projet' => $projet,
            'devis' => $devis,
        ]);
    }

    /**
    * @param Projet $projet
     * @Route(name="user_projet_listOfU_note", path="/user/projets/Note/listOfU/{id}", methods={"GET"})
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function getListOfUserP(Request $request, Projet $projet)
    {
        $form = $this->createForm(EquipeCollectionType::class, $projet);
        return $this->render('Back/Projet/list.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route(name="user_projet_setNote", path="/user/projets/Note/setNotes", methods={"GET"})
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function setUserNote(Request $request)
    {
         $response = new Response(
            'Content',
            Response::HTTP_OK,
            ['content-type' => 'text/html']
        );
        return $response;
    }


}