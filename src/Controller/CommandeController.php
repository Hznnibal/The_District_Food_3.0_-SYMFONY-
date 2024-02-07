<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Commande;
use App\Repository\PlatRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Detail;

class CommandeController extends AbstractController
{
    #[Route('/commande', name: 'app_commande', methods: ['POST'])]
    public function passerCommande(Request $request, PlatRepository $platRepository, EntityManagerInterface $entityManager): Response
    {
        $formData = $request->request->all();
        $selectedPlats = $formData['selected_plats'] ?? [];
        // dd($selectedPlats);

        $commande = new Commande();
        $commande->setUtilisateur($this->getUser());
        $commande->setDateCommande(new \DateTime());
        $commande->setEtat(0);

        $total = 0;

        $tab = [];
        foreach ($selectedPlats as $platId => $platData) {
            $plat = $platRepository->find($platId);

            if ($plat && $platData['quantity'] > 0) {
                $tab[] = [
                    "quantity" => $platData['quantity'],
                    "plat" => $plat
                ];
                $detail = new Detail();
                $detail->setPlat($plat);
                $detail->setCommande($commande);
                $detail->setQuantite($platData['quantity']);
                $entityManager->persist($detail);
            
                $total += $plat->getPrix() * $platData['quantity'];
            }
        }

        $commande->setTotal($total);
        $entityManager->persist($commande);
        $entityManager->flush();

        $message = 'La commande a été effectuée avec succès. Total : ' . $total . ' €';

        return $this->render('commande/index.html.twig', [
            'message' => $message,
            'selectedPlats' => $tab,
            'total' => $total,
        ]);
    }
}
