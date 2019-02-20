<?php

namespace App\Controller\Back;

use App\Entity\User;
use App\Form\FreelancerSearchType;
use App\Form\ChangePasswordType;
use App\Form\PasswordType;
use App\Form\User1Type;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_index", methods={"GET"})
     * @param UserRepository $userRepository
     * @return Response
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('Back/user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}/show", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('Back/user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(User1Type::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index', [
                'id' => $user->getId(),
            ]);
        }

        return $this->render('Back/user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"DELETE"})
     * @param Request $request
     * @param User $user
     * @param SessionInterface $session
     * @param TokenStorageInterface $tokenStorage
     * @return Response
     */
    public function delete(Request $request, User $user, SessionInterface $session, TokenStorageInterface $tokenStorage)
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
            $tokenStorage->setToken(null);
            $session->invalidate();
            /*return new Response('suppression');*/
        }
        return $this->redirectToRoute('app_front_home');
    }

    /**
     * @Route("/freelancer", name="free_index", methods={"GET"})
     */
    public function indexFree(UserRepository $userRepository, Request $request): Response
    {
        $search = new User();
        $form = $this->createForm(FreelancerSearchType::class, $search);
        $form->handleRequest($request);

        dump($search);
        if($form->isSubmitted() && $form->isValid()){
            $freelancers = $userRepository->findFreelancers($search);
            dump($freelancers);
            return $this->render('Front/freelancer/index.html.twig', [
                'freelancers'   => $freelancers,
                'form'          => $form->createView()
            ]);
        }

        $freelancers = $userRepository->findLatest();
        return $this->render('Front/freelancer/index.html.twig', [
            'freelancers'       => $freelancers,
            'form'              => $form->createView(),
            'controller_name'   => 'freelancer',
        ]);
    }


    /**
     * @Route("/{id}/password", name="user_password", methods={"GET","POST"})
     * @param Request $request
     * @param User $user
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     */
    public function editPassword(Request $request, User $user, UserPasswordEncoderInterface $passwordEncoder): Response
    {

        $form = $this->createForm(ChangePasswordType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em=$this->getDoctrine()->getManager();
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $em->persist($user);
            $em->flush();
            $this->addFlash('notice', 'Votre mot de passe à bien été changé !');

            return $this->redirectToRoute('login');
        }

        return $this->render('Back/user/changePass.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
