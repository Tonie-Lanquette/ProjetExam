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

        if (!$creator) {
            return $this->redirectToRoute('app_login'); 
        }

        $build = new Build();

        $form = $this->createForm(BuildType::class, $build);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $build->setCreator($creator);
            $build->setCreated(new \DateTimeImmutable());
            $build->setUpdated(new \DateTimeImmutable());

            $entityManager->persist($build);
            $entityManager->flush();

            $this->addFlash('success', 'Your build has been successfully created');

            if ($build->isVisibility()) {
                return $this->redirectToRoute('app_profil_index', [], Response::HTTP_SEE_OTHER);
            } else {
                return $this->redirectToRoute('app_build_front_index', [], Response::HTTP_SEE_OTHER); 
            }
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

        if (!$creator) {
            return $this->redirectToRoute('app_login');
        }

        $article = new Article();
       

        // recuperer id des builds créer par l'utilisateur et qui ont déjà un article associer
        $excludedBuildIds = $entityManager->getRepository(Article::class)
            ->createQueryBuilder('a')
            ->select('b.id')
            ->join('a.build', 'b')
            ->where('a.user = :user')
            ->setParameter('user', $creator)
            ->getQuery()
            ->getResult();

        $excludedBuildIds = array_map(fn($item) => $item['id'], $excludedBuildIds);

        //créer form exclure id article déjà créer
        $form = $this->createForm(ArticleType::class, $article, [
            'user' => $creator,
            'excluded_build_ids' => $excludedBuildIds,
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           
            $article->setUser($creator);
            $article->setCreated(new \DateTimeImmutable());

            $entityManager->persist($article);
            $entityManager->flush();

            $this->addFlash('success', 'Your article has been successfully created');

            return $this->redirectToRoute('app_article_front_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('front/create/article.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }
}
