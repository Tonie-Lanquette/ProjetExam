<?php

namespace App\Controller\Front;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/article')]
class ArticleFrontController extends AbstractController
{
    #[Route('s', name: 'app_article_front_index')]
    public function index(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findAllByLastest();
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
        return $this->render('front/article/details.html.twig', [
            'article' => $article
        ]);
    }


    #[Route('/{title}/edit', name: 'app_article_front_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EntityManagerInterface $entityManager, ArticleRepository $articleRepository, string $title): Response
    {
        $user = $this->getUser();

        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $article = $articleRepository->findOneBy(['title' => $title]);
        if (!$article) {
            throw $this->createNotFoundException('Article not found');
        }

        $originalBuild = $article->getBuild();

        $form = $this->createForm(ArticleType::class, $article, [
            'is_edit' => true, 
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $article->setBuild($originalBuild);

            $entityManager->flush();

            return $this->redirectToRoute('app_article_front_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('front/article/edit.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    #[Route('/{title}/delete', name: 'app_article_front_delete', methods: ['POST'])]
    public function delete(Request $request, ArticleRepository $articleRepository, EntityManagerInterface $entityManager, string $title): Response
    {
        $user = $this->getUser();

        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $article = $articleRepository->findOneBy(['title' => $title]);
        if (!$article) {
            throw $this->createNotFoundException('Article not found');
        }

        // Vérifier si le token CSRF est valide
        if ($this->isCsrfTokenValid('delete' . $article->getId(), $request->request->get('_token'))) {

            // Dissocier le Build mais ne pas le supprimer
            $article->setBuild(null);

            $entityManager->remove($article);
            $entityManager->flush();

            $this->addFlash('success', 'Article supprimé avec succès');
        }

        return $this->redirectToRoute('app_article_front_index', [], Response::HTTP_SEE_OTHER);
    }


}   
