<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AproposdenousController extends AbstractController
{
    #[Route('/aproposdenous', name: 'app_aproposdenous')]
    public function index(): Response
    {
        return $this->render('aproposdenous/index.html.twig', [
            'controller_name' => 'AproposdenousController',
        ]);
    }
}
