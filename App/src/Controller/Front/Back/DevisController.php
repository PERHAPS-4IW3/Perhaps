<?php
/**
 * Created by PhpStorm.
 * User: Tounsi
 * Date: 25/02/2019
 * Time: 16:12
 */

namespace App\Controller\Front\Back;


use App\Entity\Devis;
use App\Entity\Projet;
use App\Entity\User;
use App\Form\PostulerProjetType;
use App\Repository\ProjetRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


class DevisController extends AbstractController
{

    /**
     * @var ObjectManager
     */
    private $em;

    /**
     * ProjetController constructor.
     * @param ObjectManager $em
     */
    public function __construct(ObjectManager $em)
    {

        $this->em = $em;
    }

    /**
     * @param Request $request
     * @param Projet $projets
     * @Route(name="postuler", path="/postuler/{projets}")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function Postuler(Request $request, Projet $projets)
    {
        $user = $this->getUser();
        $descriptionDevis = $request->request->get('descriptionDevis');
        $offreDevis = $request->request->get('offreDevis');
        $em = $this->getDoctrine()->getManager();
        if($user != null){
            if($request->isMethod('POST')) {
                $devis = new Devis();
                //$form = $this->createForm(PostulerProjetType::class, $devis);
                $devis->setProjet($projets);
                $devis->setEtabliPar($user);
                $devis->setOffreDevis($offreDevis);
                $devis->setDescriptionDevis($descriptionDevis);


                try{
                    $em->persist($devis);
                    $em->flush();
                } catch (\Exception $e) {
                    $this->addFlash('warning',$e->getMessage());
                    return $this->redirectToRoute('app_front_home');
                }

                $this->addFlash('success', "Vous avez postulé avec succès au projet : ".$projets->getNomProjet());
                return $this->redirectToRoute('app_front_home');
                //$form->handleRequest($request);
                //dump($form);

                /*if ($form->isSubmitted() && $form->isValid()) {
                    dump($form);
                    //$this->em->persist($devis);
                    //$this->em->flush();
                    $this->addFlash('success', 'Vous avez postulé au projet : ' . $projet->getNomProjet());
                }*/
                /*return $this->render('Front/Devis/postuler.html.twig', [
                    'devis' => $devis,
                    'form' => $form->createView()
                ]);*/
            }
        }else{
            return $this->redirectToRoute('app_front_home');
        }
    }

    /**
     * @param Request $request
     * @param Projet $projet
     * @param User $user
     * @Route(name="demanderDevis", path="/demande/devis/{user}")
     */
    public function demanderDevis(Request $request, Projet $projet, User $user)
    {

    }


}