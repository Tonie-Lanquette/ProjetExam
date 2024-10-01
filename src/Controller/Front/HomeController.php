<?php

namespace App\Controller\Front;

use App\Repository\ArticleRepository;
use App\Repository\BuildRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/')]
class HomeController extends AbstractController
{
    #[Route(name: 'app_home')]
    public function index(BuildRepository $buildRepository, ArticleRepository $articleRepository): Response
    {
        // get 5 last created builds
        $builds = $buildRepository->findLatestPublicBuilds(5);

        // get 5 last created article
        $articles = $articleRepository->findAll();
        $articles = $articleRepository->findBy(array(), array('created' => 'DESC'), 5);

        return $this->render('front/home/index.html.twig', [
            'builds' => $builds,
            'articles' => $articles
        ]);
    }
}
