<?php

namespace App\Controller\Front;

use App\Entity\Build;
use App\Form\BuildType;
use App\Repository\ArticleRepository;
use App\Repository\BuildRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/build')]
class BuildFrontController extends AbstractController
{
    #[Route('s' , name: 'app_build_front_index')]
    public function index(BuildRepository $buildRepository): Response
    {

        $builds = $buildRepository->findPublicBuilds();

        return $this->render('front/build/index.html.twig', [
            'builds' => $builds
        ]);
    }

    #[Route('/{title}', name: 'app_build_front_details')]
    public function details(BuildRepository $buildRepository, ArticleRepository $articleRepository, string $title): Response
    {
        $build = $buildRepository->findOneBy(['title' => $title]);
        if (!$build) {
            throw $this->createNotFoundException('Build not found');
        }
        $article = $articleRepository->findOneBy(['build' => $build]);

        return $this->render('front/build/details.html.twig', [
            'build' => $build,
            'article' => $article,
        ]);
    }

    #[Route('/{title}/edit', name: 'app_build_front_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EntityManagerInterface $entityManager, BuildRepository $buildRepository, string $title): Response
    {
        $build = $buildRepository->findOneBy(['title' => $title]);
        if (!$build) {
            throw $this->createNotFoundException('Build not found');
        }
        
        $form = $this->createForm(BuildType::class, $build);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $build->setUpdated(new \DateTimeImmutable());

            $entityManager->flush();

            return $this->redirectToRoute('app_build_front_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('front/build/edit.html.twig', [
            'build' => $build,
            'form' => $form,
        ]);
    }
}
