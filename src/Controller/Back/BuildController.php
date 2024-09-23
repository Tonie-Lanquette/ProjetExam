<?php

namespace App\Controller\Back;

use App\Entity\Build;
use App\Entity\Slot;
use App\Form\BuildSlotType;
use App\Form\BuildType;
use App\Repository\BuildRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('admin/build')]
final class BuildController extends AbstractController
{
    #[Route(name: 'app_build_index', methods: ['GET'])]
    public function index(BuildRepository $buildRepository): Response
    {
        return $this->render('admin/build/index.html.twig', [
            'builds' => $buildRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_build_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {

        $creator = $this->getUser();

        $build = new Build();

        $build -> setCreator($creator);

        $form = $this->createForm(BuildType::class, $build);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $build->setCreated(new \DateTimeImmutable());
            $build->setUpdated(new \DateTimeImmutable());

            $entityManager->persist($build);
            $entityManager->flush();

            return $this->redirectToRoute('app_build_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/build/new.html.twig', [
            'build' => $build,
            'form' => $form,
        ]);
    }

    // Dans le contrôleur BuildController
    #[Route('/new_combined', name: 'app_build_slot_new', methods: ['GET', 'POST'])]
    public function newCombined(Request $request, EntityManagerInterface $entityManager): Response
    {
        $creator = $this->getUser();

        $build = new Build();
        $build->setCreator($creator);

        $slot = new Slot();

        $form = $this->createForm(BuildSlotType::class, $build);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $build->setCreated(new \DateTimeImmutable());
            $build->setUpdated(new \DateTimeImmutable());

            // Persister Build
            $entityManager->persist($build);

            // Persister Slot lié au Build (vous devez gérer cette association)
            $slot->setBuild($build);
            $entityManager->persist($slot);

            $entityManager->flush();

            return $this->redirectToRoute('app_build_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/build/completeBuild.html.twig', [
            'form' => $form,
        ]);
    }


    #[Route('/{id}', name: 'app_build_show', methods: ['GET'])]
    public function show(Build $build): Response
    {
        return $this->render('admin/build/show.html.twig', [
            'build' => $build,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_build_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Build $build, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BuildType::class, $build);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $build->setUpdated(new \DateTimeImmutable());

            $entityManager->flush();

            return $this->redirectToRoute('app_build_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/build/edit.html.twig', [
            'build' => $build,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_build_delete', methods: ['POST'])]
    public function delete(Request $request, Build $build, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $build->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($build);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_build_index', [], Response::HTTP_SEE_OTHER);
    }
}
