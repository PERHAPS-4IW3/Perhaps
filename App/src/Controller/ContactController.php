<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function contact(Request $request, \Swift_Mailer $mailer)
    {
        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $contactFormData = $form->getData();
            dump($contactFormData);

            $message = (new \Swift_Message($contactFormData['sujet']))
                ->setFrom($contactFormData['mail'])
                ->setTo('noreply.perhaps@gmail.com')
                ->setBody(
                    "<html><body><h3>Prenom : ".$contactFormData['prenom'] ."<br /> Nom : "
                    . $contactFormData['nom'] . "</h3><h4>"
                    . $contactFormData['mail']. "</h4><p>vous a écrit un mail : </p><p>"
                    . $contactFormData['message']."</p></body></html>",
                    'text/html'
                );
            if($mailer->send($message)){
                $this->addFlash('success', 'votre email a bien été envoyé');
                return $this->redirectToRoute('contact');
            }
        }

        return $this->render('contact.html.twig', [
            'our_form' => $form->createView()
        ]);
    }
}