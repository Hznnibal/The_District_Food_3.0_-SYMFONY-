<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Repository\PlatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;


class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(PlatRepository $platRepository, CategorieRepository $categorieRepository): Response
    {
        // Your database query logic here
        $plats = $platRepository->findMenuItems(50); // Assuming you have a method like findMenuItems in PlatRepository
        $categories = $categorieRepository->findAll(); // You can modify this according to your needs

        return $this->render('accueil/index.html.twig', [
            'plats' => $plats,
            'categories' => $categories,
        ]);
    }
}
