<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Repository\PlatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use App\Entity\Plat;
use App\Entity\Utilisateur;

class MenuController extends AbstractController
{
    #[Route('/menu', name: 'app_menu')]
    public function index(PlatRepository $platRepository, CategorieRepository $categorieRepository): Response
    {
        // Your database query logic here
        $plats = $platRepository->findMenuItems(50); // Assuming you have a method like findMenuItems in PlatRepository
        $categories = $categorieRepository->findAll(); // You can modify this according to your needs

        return $this->render('menu/index.html.twig', [
            'plats' => $plats,
            'categories' => $categories,
        ]);
    }

    #[Route('/panier', name: 'app_panier')]
    public function ajouterAuPanierAction(Request $request)
    {
        // Logique pour ajouter un plat au panier
        $libelle = $request->request->get('libelle');
        $prix = $request->request->get('prix');

        // Logique pour stocker le plat dans le panier (session, base de données, etc.)

        return new JsonResponse(['success' => true]);
    }
}
