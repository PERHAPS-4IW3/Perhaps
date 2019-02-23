<?php


namespace App\Controller\Back;



use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


/**
 * @Route("/payement")
 */
class PayementController
{

    /**
     * @Route(name="stripe", path="/stripe")
     * @param Request $request
     * @return Response
     */
    public function payement(Request $request)
    {
        // Set your secret key: remember to change this to your live secret key in production
        // See your keys here: https://dashboard.stripe.com/account/apikeys
        \Stripe\Stripe::setApiKey("sk_test_1KKRssEaSvAsaKKWK6KTp8QR");

        // Token is created using Checkout or Elements!
        // Get the payment token ID submitted by the form:
        $token = $request->request->get('stripeToken');
        $charge = \Stripe\Charge::create([
            'amount' => 999,
            'currency' => 'usd',
            'description' => 'Example charge',
            'source' => $token ,
        ]);
        return $this->render('Back/Payement/stripe.html.twig');

    }




}