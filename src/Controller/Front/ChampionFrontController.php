<?php

namespace App\Controller\Front;

use App\Repository\ChampionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/champion')]
class ChampionFrontController extends AbstractController
{
    #[Route(name: 'app_champion_front_index')]
    public function index(ChampionRepository $championRepository): Response
    {
        $champions = $championRepository->findAll();

        return $this->render('front/champion/index.html.twig', [
            'champions'-> $champions
        ]);
    }
}
