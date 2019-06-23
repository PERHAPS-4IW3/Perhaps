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
use App\Entity\Devis;
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
     * @Route(name="user_projet_edit", path="/user/projets/{id}", methods={"GET", "POST"})
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
     * @Route(name="user_projet_delete", path="/user/projets/delete/{id}", methods={"GET"})
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
     * @Route(name="user_projet_offers", path="/user/projets/offers/{id}", methods={"GET", "POST"})
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
     * @Route(name="user_projet_noter_user", path="/user/projets/noteUser/{id}", methods={"GET", "POST"})
     * @param Projet $projet
     * @return Response
     */
    public function manageFreelancer(Projet $projet): Response
    {
        $devi = $this->em->getRepository(Devis::class)->findOneBy(['id' => 10]);
        $devi->setFlag(NULL);
        return $this->render('Back/Projet/Manage/index.html.twig', [
            'listeDesequipe' => $projet->getListDesEquipes(),
            'notation' => $projet->getListCommentaireEtNote(),
            'devis'=> $projet->getListDevis()
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
     * @Route(name="user_projet_setNote", path="/user/projets/Note/setNote", methods={"GET"})
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function setUserNote(Request $request)
    {
        $data = json_decode($request->query->get("data"), true);
        if(!$noteEtCommentaire = $this->em->getRepository(NoteEtCommentaire::class)->findOneBy(
           array ( 'idProjet' => $data["projet"],  'developpeur' =>  $data["user"]))
            )
        {
            $noteEtCommentaire = new NoteEtCommentaire();
        }
        $noteEtCommentaire->setCommentaire($data["commentaire"]);
        $noteEtCommentaire->setNote(intval($data["note"]));
        $noteEtCommentaire->setDeveloppeur($this->em->getRepository(User::class)->findOneBy(['id' => $data["user"]]));
        $noteEtCommentaire->setIdProjet($this->em->getRepository(Projet::class)->findOneBy(['id' => $data["projet"]]));  


        $this->em->merge($noteEtCommentaire);
        $this->em->flush();

         $response = new Response(
            '',
            Response::HTTP_OK,
            ['content-type' => 'text/html']
        );
        return $response;
    }     


     /**
     * @Route(name="user_projet_delete_Freelancer", path="/user/projets/freelancer/deleteFreelancer", methods={"GET"})
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteFreelancer(Request $request)
    {
        $data = json_decode($request->query->get("data"), true);
        if($data["id_equipe"])
        {
            $equipe = $this->em->getRepository(Equipe::class)->findOneBy(['id' => $data["id_equipe"]]);
            if( $equipe->getListParticipants()->count()>1)
            {
                $user = $equipe->getListParticipants()[0];
                $equipe->setChefDeProjet($user);
                $equipe->removeListParticipant($user);
            }else
            {
                $this->em->remove($equipe);
                /*$projet = $equipe->getIdProjet();
                $projet->removeListDesEquipe($equipe);
                $equipe = new Equipe();
                $projet->addListDesEquipe($equipe);
                $this->em->persist($projet);*/
            }
        }
        else{
            $equipe = $this->em->getRepository(Equipe::class)->findOneBy(['id' => $data["id_equipe"]]);
            $equipe->removeListParticipant($this->em->getRepository(User::class)->findOneBy(['id' => $data["id_user"]]));    
        }
        $this->em->flush();
        $response = new Response(
            '',
            Response::HTTP_OK,
            ['content-type' => 'text/html']
        );
        return $response;
    }

     /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route(name="user_projet_Freelancer_equipe", path="/user/projets/freelancer/ajouterfreelancer", methods={"GET"})
     */
    public function ajouterFreelancer(Request $request)
    {
        $data = json_decode($request->query->get("data"), true);
        $projet = $this->em->getRepository(Projet::class)->findOneBy(['id' => $data["id_projet"]]);
        $devi = $this->em->getRepository(Devis::class)->findOneBy(['id' => $data["id_devi"]]);
        $devi->setFlag(0);
        $equipe = new Equipe();
        $ischef = false;
        $user = $this->em->getRepository(User::class)->findOneBy(['id' => $data["id_user"]]);
        if($projet->getListDesEquipes()->isEmpty())
        {
            $ischef = true;
            $equipe->setChefDeProjet($user);
            $equipe->setIdProjet($projet);
            $this->em->persist($equipe);
        }else
        {
            $projet->getListDesEquipes(){0}->addListParticipant($user);
            $equipe=$projet->getListDesEquipes(){0};
        }
        $this->em->flush();
        //var_dump($equipe);
        
        $response = new Response(
            json_encode([
                'equipeid'=> $equipe->getId(),
                'ischef'=>$ischef,
                'idProjet'=> $equipe->getIdProjet()->getId(),
                'chefDeProjet'=>$user->getId(),
                'prenomUser'=> $user->getPrenomUser(),
                'nomUser'=>$user->getNomUser()
            ]),
            Response::HTTP_OK,
            ['content-type' => 'application/json']
        );
        return $response;
    }



    /**
     * @Route(name="user_projet_setNotes", path="/user/projets/Note/setNotes", methods={"GET"})
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function setUserNotes(Request $request)
    {
        $data = json_decode($request->query->get("data"), true);
        $user = $this->em->getRepository(User::class)->findOneBy(['email' => $data["email"]]);

        if(!$noteEtCommentaire = $this->em->getRepository(NoteEtCommentaire::class)->findOneBy(
           array ( 'idProjet' => $data["projet"],  'developpeur' =>  $data["user"]))
            )
        {
            $noteEtCommentaire = new NoteEtCommentaire();
        }
        $noteEtCommentaire->setCommentaire($data["commentaire"]);
        $noteEtCommentaire->setNote(intval($data["note"]));
        $noteEtCommentaire->setDeveloppeur($this->em->getRepository(User::class)->findOneBy(['id' => $data["user"]]));
        $noteEtCommentaire->setIdProjet($this->em->getRepository(Projet::class)->findOneBy(['id' => $data["projet"]]));        
        $this->em->merge($noteEtCommentaire);
        $this->em->flush();

         $response = new Response(
            '',
            Response::HTTP_OK,
            ['content-type' => 'text/html']
        );
        return $response;
    }     
      

}