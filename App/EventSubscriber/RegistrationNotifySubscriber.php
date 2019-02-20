<?php
/**
 * Created by PhpStorm.
 * User: Tounsi
 * Date: 17/02/2019
 * Time: 23:12
 */

namespace App\EventSubscriber;

use App\Entity\User;
use Doctrine\ORM\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

/*
 * Envoi un mail de binevenue à chaque création d'un utilisateur
 */
class RegistrationNotifySubscriber implements EventSubscriberInterface
{
    private $mailer;
    private $sender;

    public function __construct(\Swift_Mailer $mailer, $sender)
    {
        //On injecte notre expéditeur et la classe pour envoyer nos mails
        $this->mailer = $mailer;
        $this->sender = $sender;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            //le nom de l'event et le nom de la fonction qui sera déclenché
            Events::USER_REGISTERED => 'onUserRegistrated',
        ];
    }

    public function onUserRegistrated(GenericEvent $event): void
    {
        $user = $event->getSubject();

        $subject = "Bienvenue sur Perhaps ! ";
        $body = "Que vous soyez Freelancer ou Porteur de Projet, cette application est faite pour vous !";

        $message = (new \Swift_Message())
            ->setSubject($subject)
            ->setTo($user->getEmail())
            ->setFrom($this->sender)
            ->setBody($body, 'text/html')
            ;

        $this->mailer->send($message);
    }
}