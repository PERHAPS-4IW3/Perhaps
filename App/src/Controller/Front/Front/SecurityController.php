<?php
/**
 * Created by PhpStorm.
 * User: Tounsi
 * Date: 03/02/2019
 * Time: 21:31
 */
namespace App\Controller\Front\Front;
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
use App\Services\Mailer;
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
     * @param Mailer $mailer
     * @param TokenGeneratorInterface $tokenGenerator
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder, Mailer $mailer, TokenGeneratorInterface $tokenGenerator)
    {
        if ($this->getUser() instanceof User) {
            return $this->redirectToRoute('app_front_home');
        }
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        $roles = $request->request->get("user")["roles"];
        if ($form->isSubmitted() && $form->isValid()) {


            if(in_array('ROLE_USER', $roles)) {
                $user->setTarifHoraireFreelancer(-1);
                $user->setPresentationFreelancer(null);
                $user->setNomSociete(null);
            }

            $user->setRoles($roles);
            $confirmationToken = $tokenGenerator->generateToken();
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $user->setConfirmationToken($confirmationToken);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            // on utilise le service Mailer
            $bodyMail = $mailer->createBodyMail('Front/Security/mailConfirmationEmail.html.twig', [
                'user' => $user
            ]);
            $mailer->sendMessage('noreply.perhaps@gmail.com', $user->getEmail(), 'Validation email', $bodyMail);
            $this->addFlash('success', "Un mail va vous être envoyé afin que vous puissiez valider votre inscription.");
            return $this->redirectToRoute('app_front_home');
        }
        return $this->render(
            'Front/Security/register.html.twig', [
                'form' => $form->createView()
            ]
        );
    }
    /**
     * @Route(name="confirmAction", path="/activate/{token}")
     * @param Request $request
     * @param $token
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function confirmAction(Request $request, string $token)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->findOneBy(array('confirmationToken' => $token));
        if (!$user)
        {
            $this->createNotFoundException("Aucun utilisateur trouvé pour ce token");
        }
        $user->setConfirmationToken(null);
        $user->setIsActive(true);
        $em->persist($user);
        $em->flush();
        return $this->redirectToRoute('login');
    }
    /**
     * @Route(name="forgottenPassword", path="/mot_de_passe_oublie")
     * @param Request $request
     * @param Mailer $mailer
     * @param TokenGeneratorInterface $tokenGenerator
     * @return Response
     */
    public function forgottenPassword(Request $request, Mailer $mailer, TokenGeneratorInterface $tokenGenerator): Response
    {
        if($request->isMethod('POST')){
            $email = $request->request->get('email');
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository(User::class)->findOneBy(['email' => $email]);
            //aucun email associé
            if($user === null){
                $this->addFlash('danger', 'Email inconnu');
                return $this->redirectToRoute('login');
            }
            //générer le token
            $token = $tokenGenerator->generateToken();
            try{
                $user->setResetToken($token);
                //enregistrement de la date de création du token
                $user->setPasswordRequestedAt(new \DateTime());
                $em->flush();
            } catch (\Exception $e) {
                $this->addFlash('warning',$e->getMessage());
                return $this->redirectToRoute('app_front_home');
            }
            // on utilise le service Mailer
            $bodyMail = $mailer->createBodyMail('Front/Security/mailResetPassword.html.twig', [
                'user' => $user
            ]);
            $mailer->sendMessage('noreply.perhaps@gmail.com', $user->getEmail(), 'Renouvellement du mot de passe', $bodyMail);
            $this->addFlash('success', "Un mail va vous être envoyé afin que vous puissiez renouveller votre mot de passe. Le lien que vous recevrez sera valide 15 minutes.");
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
            if($user === null || !$this->isRequestInTime($user->getPasswordRequestedAt())){
                $this->addFlash('danger', 'Token inconnu');
                return $this->redirectToRoute('app_front_home');
            }
            $user->setResetToken(null);
            $user->setPasswordRequestedAt(null);
            $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('password')));
            $em->flush();
            $this->addFlash('success', 'Mot de passe mis à jour');
            return $this->redirectToRoute('app_front_home');
        }else {
            return $this->render('Front/Security/resetPassword.html.twig', ['token' => $token]);
        }
    }
    // si supérieur à 15 min, retourne false
    //sinon retourne true
    private function isRequestInTime(\Datetime $passwordRequestedAt = null)
    {
        if ($passwordRequestedAt === null)
        {
            return false;
        }
        $now = new \DateTime();
        $interval = $now->getTimestamp() - $passwordRequestedAt->getTimestamp();
        $daySeconds = 60 * 15;
        $response = $interval > $daySeconds ? false : $reponse = true;
        return $response;
    }
}