<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoadMoreController extends AbstractController
{
    #[Route('/load/more', name: 'app_load_more')]
    public function index(): Response
    {
        return $this->render('load_more/index.html.twig', [
            'controller_name' => 'LoadMoreController',
        ]);
    }
}
