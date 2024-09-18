<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/article')]
class ArticleFrontController extends AbstractController
{
    #[Route(name: 'app_article_front_index')]
    public function index(): Response
    {
        return $this->render('front/article/index.html.twig', [
            'controller_name' => 'ArticleController',
        ]);
    }
}
