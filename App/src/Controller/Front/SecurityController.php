<?php
/**
 * Created by PhpStorm.
 * User: Tounsi
 * Date: 03/02/2019
 * Time: 21:31
 */

namespace App\Controller\Front;

use App\Form\UserType;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    /**
     * @Route(name="login", path="/login")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('Front/Security/login.html.twig', [
            'error' => $error,
            'lastUsername' => $lastUsername
        ]);
    }

    /**
     * @Route(name="registration", path="/register")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {

        if ($this->getUser() instanceof User) {
            return $this->redirectToRoute('app_front_home');
        }
        $user = new User();
        $form = $this->createForm(UserType::class, $user, [
            'validation_groups' => array('User', 'registration')
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if($request->query->get('role') == 'ROLE_USERl') {
                $user->setTarifHoraireFreelancer(null);
                $user->setNomSocieteFreelancer(null);
                $user->setPresentationFreelancer(null);
            }
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            //$user->setRoles(['ROLE_USER']);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('login');
        }
        return $this->render(
            'Front/Security/register.html.twig', [
                'form' => $form->createView()
            ]
        );
    }

    /**
     * @Route(name="forgottenPassword", path="/mot_de_passe_oublie")
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @param \Swift_Mailer $mailer
     * @param TokenGeneratorInterface $tokenGenerator
     * @return Response
     */
    public function forgottenPassword(Request $request, UserPasswordEncoderInterface $encoder,
        \Swift_Mailer $mailer, TokenGeneratorInterface $tokenGenerator): Response
    {
        if($request->isMethod('POST')){
            $email = $request->request->get('email');
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository(User::class)->findOneBy(['email' => $email]);


            if($user === null){
                $this->addFlash('danger', 'Email inconnu');
                return $this->redirectToRoute('login');
            }
            $token = $tokenGenerator->generateToken();

            try{
                $user->setResetToken($token);
                $em->flush();
            } catch (\Exception $e) {
                $this->addFlash('warning',$e->getMessage());
                return $this->redirectToRoute('app_front_home');
            }

            $url = $this->generateUrl('resetPassword', array('token' => $token), UrlGeneratorInterface::ABSOLUTE_URL);
            $message = (new \Swift_Message('Mot de passe oublié'))
                ->setFrom('noreply.perhaps@gmail.com')
                ->setTo($user->getEmail())
                ->setBody(
                    "Voici le token pour réinitialiser votre mot de passe : " . $url,
                    'text/html'
                );

            $mailer->send($message);
            $this->addFlash('success', 'Un mail vous a été envoyé');
            return $this->redirectToRoute('app_front_home');
        }
        return $this->render('Front/Security/recoverPassword.html.twig');
    }

    /**
     * @Route(name="resetPassword", path="/reset_password/{token}")
     * @param Request $request
     * @param string $token
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function resetPassword(Request $request, string $token, UserPasswordEncoderInterface $passwordEncoder)
    {
        if($request->isMethod('POST')){
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository(User::class)->findOneBy(array('resetToken' => $token));

            if($user === null){
                $this->addFlash('danger', 'Token inconnu');
                return $this->redirectToRoute('app_front_home');
            }

            $user->setResetToken(null);
            $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('password')));
            $em->flush();

            $this->addFlash('success', 'Mot de passe mis à jour');

            return $this->redirectToRoute('app_front_home');
        }else {
            return $this->render('Front/Security/resetPassword.html.twig', ['token' => $token]);
        }
    }
}