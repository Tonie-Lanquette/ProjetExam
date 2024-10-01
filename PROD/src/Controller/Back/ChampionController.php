<?php

namespace App\Controller\Back;

use App\Controller\Service\PopulateChampionDb;
use App\Entity\Champion;
use App\Form\ChampionType;
use App\Repository\ChampionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('admin/champion')]
#[IsGranted('ROLE_ADMIN')]
final class ChampionController extends AbstractController
{
    #[Route(name: 'app_champion_index', methods: ['GET'])]
    public function index(ChampionRepository $championRepository): Response
    {
        return $this->render('admin/champion/index.html.twig', [
            'champions' => $championRepository->findAll(),
        ]);
        
    }

    #[Route('/new', name: 'app_champion_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $champion = new Champion();
        $form = $this->createForm(ChampionType::class, $champion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($champion);
            $entityManager->flush();

            return $this->redirectToRoute('app_champion_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/champion/new.html.twig', [
            'champion' => $champion,
            'form' => $form,
        ]);
    }
    
    #[Route('/update', name: 'app_champion_update')]
    public function upadte(PopulateChampionDb $populateChampionDb): Response
    {

       
        $fetchChampionData = $populateChampionDb->fetchChampionData();

        $championData = $populateChampionDb->getChampionData($fetchChampionData);
        
        $populateChampionDb->saveChampionData($championData);

    
        return $this->redirectToRoute('app_champion_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}', name: 'app_champion_show', methods: ['GET'])]
    public function show(Champion $champion): Response
    {
        return $this->render('admin/champion/show.html.twig', [
            'champion' => $champion,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_champion_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Champion $champion, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ChampionType::class, $champion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_champion_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/champion/edit.html.twig', [
            'champion' => $champion,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_champion_delete', methods: ['POST'])]
    public function delete(Request $request, Champion $champion, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $champion->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($champion);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_champion_index', [], Response::HTTP_SEE_OTHER);
    }

   
}
