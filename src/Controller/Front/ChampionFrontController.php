<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/champion')]
class ChampionFrontController extends AbstractController
{
    #[Route(name: 'app_champion_front_index')]
    public function index(): Response
    {
        return $this->render('front/champion/index.html.twig', [
            'controller_name' => 'ChampionFrontController',
        ]);
    }
}
