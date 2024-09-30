<?php

namespace App\Controller\Front;

use App\Entity\Article;
use App\Entity\Build;
use App\Form\ArticleType;
use App\Form\BuildType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/create')]
class CreateController extends AbstractController
{
    #[Route(name: 'app_create_index')]
    public function index(): Response
    {
        return $this->render('front/create/index.html.twig', [
            'controller_name' => 'CreateController',
        ]);
    }

    #[Route( '/build' , name: 'app_create_build')]
    public function build(Request $request, EntityManagerInterface $entityManager): Response
    {

        $creator = $this->getUser();

        $build = new Build();

        $build->setCreator($creator);

        $form = $this->createForm(BuildType::class, $build);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $build->setCreated(new \DateTimeImmutable());
            $build->setUpdated(new \DateTimeImmutable());

            $entityManager->persist($build);
            $entityManager->flush();

            return $this->redirectToRoute('app_build_front_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('front/create/build.html.twig', [
            'build' => $build,
            'form' => $form,
        ]);
    }

    #[Route('/article', name: 'app_create_article')]
    public function article(Request $request, EntityManagerInterface $entityManager): Response
    {

        $creator = $this->getUser();

        $article = new Article();

        $article->setUser($creator);
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $article->setCreated(new \DateTimeImmutable());

            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('app_article_front_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('front/create/article.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }
}
