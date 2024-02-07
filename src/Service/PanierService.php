<?php

namespace App\Service;


use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Security;

class PanierService
{
    private $session;
    private $security;

    public function __construct(SessionInterface $session, Security $security)
    {
        $this->session = $session;
        $this->security = $security;
    }

    public function ajouterAuPanier(string $libelle, float $prix)
    {
        $panier = $this->getPanier();

        // Vérifier si le plat est déjà dans le panier
        $index = $this->trouverIndexDansPanier($libelle, $panier);

        if ($index !== false) {
            // Le plat est déjà dans le panier, mettez à jour la quantité ou effectuez toute autre logique nécessaire
            $panier[$index]['quantite'] += 1;
        } else {
            // Ajouter le plat au panier
            $panier[] = [
                'libelle' => $libelle,
                'prix' => $prix,
                'quantite' => 1,
            ];
        }

        $this->sauvegarderPanier($panier);
    }

    public function getPanier(): array
    {
        return $this->session->get('panier', []);
    }

    public function viderPanier()
    {
        $this->session->remove('panier');
    }

    private function sauvegarderPanier(array $panier)
    {
        $this->session->set('panier', $panier);
    }

    private function trouverIndexDansPanier(string $libelle, array $panier): int
    {
        foreach ($panier as $index => $plat) {
            if ($plat['libelle'] === $libelle) {
                return $index;
            }
        }

        return false;
    }

    public function calculerTotal(): float
    {
    $panier = $this->getPanier();
    $total = 0;

    foreach ($panier as $item) {
        $total += $item['prix'] * $item['quantite'];
    }

    return $total;
}



}
