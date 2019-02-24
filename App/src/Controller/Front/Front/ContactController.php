<?php

namespace App\Controller\Front\Front;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\Mailer;


class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     * @param Request $request
     * @param Mailer $mailer
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function contact(Request $request, Mailer $mailer)
    {
        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $contactFormData = $form->getData();

            // on utilise le service Mailer
            $bodyMail = $mailer->createBodyMail('Front/Contact/mailContact.html.twig', [
                'form' => $contactFormData
            ]);
            $mailer->sendMessage($contactFormData['mail'], 'muhammad.tounsi@hotmail.fr', $contactFormData['sujet'], $bodyMail);
            $this->addFlash('success', "Votre email a bien été envoyé");

                return $this->redirectToRoute('contact');
            }

        return $this->render('Front/Contact/contact.html.twig', [
            'our_form' => $form->createView()
        ]);
    }
}