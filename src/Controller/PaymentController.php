<?php

// src/Controller/PaymentController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Stripe\Stripe;
use Stripe\Charge;

class PaymentController extends AbstractController
{
    #[Route('/payment', name: 'app_payment')]
    public function payment(Request $request): Response
    {
        // Configurez votre clé secrète Stripe
        Stripe::setApiKey('VOTRE_CLÉ_SECRÈTE_STRIPE');

        return $this->render('payment/index.html.twig', [
            'stripe_public_key' => 'VOTRE_CLÉ_PUBLIQUE_STRIPE',
        ]);
    }

    // /**
    //  * @Route("/charge", name="charge", methods={"POST"})
    //  */
    // public function charge(Request $request): Response
    // {
    //     // Traitement de la transaction avec le jeton Stripe
    //     $token = $request->request->get('stripeToken');

    //     try {
    //         // Configurez votre clé secrète Stripe
    //         Stripe::setApiKey('VOTRE_CLÉ_SECRÈTE_STRIPE');

    //         // Effectuez la charge avec Stripe
    //         $charge = Charge::create([
    //             'amount' => 1000, // Montant en cents (par exemple, 10,00 €)
    //             'currency' => 'eur',
    //             'description' => 'Achat sur votre site',
    //             'source' => $token,
    //         ]);

    //         // Gestion du succès de la charge
    //         // Vous pouvez effectuer des actions supplémentaires ici (par exemple, enregistrer la commande dans la base de données)
    //         // ...

    //         return $this->redirectToRoute('payment_success');
    //     } catch (\Exception $e) {
    //         // Gestion des erreurs de charge
    //         // Vous pouvez rediriger vers une page d'erreur ou afficher un message d'erreur
    //         // ...

    //         return $this->redirectToRoute('payment_error');
    //     }
    // }

    /**
     * @Route("/payment/success", name="payment_success")
     */
    public function success(): Response
    {
        return $this->render('payment/success.html.twig');
    }

    /**
     * @Route("/payment/error", name="payment_error")
     */
    public function error(): Response
    {
        return $this->render('payment/error.html.twig');
    }
}
