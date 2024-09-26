<?php

namespace App\Controller\Front;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\MakerBundle\Str;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/article')]
class ArticleFrontController extends AbstractController
{
    #[Route('s', name: 'app_article_front_index')]
    public function index(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findAll();
        // dd($articles);
        return $this->render('front/article/index.html.twig', [
            'articles' => $articles
        ]);
    }

    #[Route('/{title}', name: 'app_article_front_details')]
    public function details(ArticleRepository $articleRepository, string $title): Response
    {
        $article = $articleRepository->findOneBy(['title' => $title]);
        if (!$article) {
            throw $this->createNotFoundException('Article not found');
        };
        // dd($article);
        return $this->render('front/article/details.html.twig', [
            'article' => $article
        ]);
    }
}
