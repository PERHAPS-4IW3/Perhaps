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
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_index", methods={"GET"})
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
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
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
     * @Route("/{id}/delete", name="user_delete", methods={"DELETE"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
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
     */
    public function editPassword(Request $request, User $user): Response
    {
        $form = $this->createForm(ChangePasswordType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_show', [
                'id' => $user->getId(),
            ]);
        }

        return $this->render('Back/user/changePass.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}
