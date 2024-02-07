<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PlatRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Entity\Plat;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Entity\Utilisateur;
use App\Repository\CategorieRepository;
use App\Entity\Commande;
use App\Entity\Detail;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/cart', name: 'cart_')]
class PanierController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(SessionInterface $session, PlatRepository $platsRepository, CategorieRepository $categories): Response
    {
        $panier = $session->get("panier", []);

        if (!is_array($panier)) {
            $panier = [];
        }

        $plats = [];
        $total = 0;

        $panier = array_filter($panier);

        foreach ($panier as $id => $quantite) {
            $plat = $platsRepository->find($id);

            if ($plat) {
                $plats[] = [
                    'libelle' => $plat->getLibelle(),
                    'prix' => $plat->getPrix(),
                    'id' => $plat->getId(),
                    'quantite' => $quantite,
                ];
                $total += $plat->getPrix() * $quantite;
            }
        }

        return $this->render('panier/index.html.twig', compact("plats", "total"));
    }

    #[Route("/add/{id}", name:"add")]
    public function add(Plat $plat, SessionInterface $session): Response
    {
        $panier = $session->get("panier", []);
        $id = $plat->getId();

        if (!is_array($panier)) {
            $panier = [];
        }

        if (!empty($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }

        $session->set("panier", $panier);

        return $this->redirectToRoute("app_menu");
    }

    #[Route("/remove/{id}", name:"remove")]
    public function remove(Plat $plat, SessionInterface $session)
    {
        $panier = $session->get("panier", []);
        $id = $plat->getId();

        if(!empty($panier[$id])){
            if($panier[$id] > 1){
                $panier[$id]--;
            } else {
                unset($panier[$id]);
            }
        }

        $session->set("panier", $panier);

        return $this->redirectToRoute("cart_index");
    }

    #[Route("/delete/{id}", name:"delete")]
    public function delete(Plat $plat, SessionInterface $session)
    {
        $panier = $session->get("panier", []);
        $id = $plat->getId();

        if(!empty($panier[$id])){
            unset($panier[$id]);
        }

        $session->set("panier", $panier);

        return $this->redirectToRoute("cart_index");
    }

    #[Route("/delete", name:"delete_all")]
    public function deleteAll(SessionInterface $session)
    {
        $session->remove("panier");

        return $this->redirectToRoute("cart_index");
    }

    #[Route('/commande', name: 'commande', methods: ['POST'])]
    public function passerCommande(SessionInterface $session,Request $request,Plat $plat, PlatRepository $platsRepository, EntityManagerInterface $entityManager): Response
    {
        $panier = $session->get("panier", []);
    
        $commande = new Commande();
        $commande->setUtilisateur($this->getUser());
        $commande->setDateCommande(new \DateTime());
        $commande->setEtat(0);
    
        $total = 0;
        $quantite = 0;
        
        foreach ($panier as $id => $quantite) {
            $plat = $platsRepository->find($id);

            if ($plat) {
                $plats[] = [
                    'libelle' => $plat->getLibelle(),
                    'prix' => $plat->getPrix(),
                    'id' => $plat->getId(),
                    'quantite' => $quantite,
                ];
                $total += $plat->getPrix() * $quantite;
               $detail = new Detail();
                $detail->setPlat($plat);
                $detail->setCommande($commande);
                $detail->setQuantite($quantite);
                $entityManager->persist($detail);
            }
        } 
    
        $commande->setTotal($total);
        $entityManager->persist($commande);
        $entityManager->flush();
    
        $message = 'La commande a été effectuée avec succès. Total : ' . $total . ' €';
    
        return $this->render('panier/index.html.twig', [
            'message' => $message,
            'plats' => $plats,
            'total' => $total,
        ]);
    }
    
}    