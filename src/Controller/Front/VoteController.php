<?php

namespace App\Controller\Front;

use App\Entity\Vote;
use App\Repository\BuildRepository;
use App\Repository\VoteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class VoteController extends AbstractController
{
    #[Route('/vote/status/{id}', name: 'app_vote_status', methods: ['GET'])]
    public function getVoteStatus(int $id, BuildRepository $buildRepository, VoteRepository $voteRepository): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->json(['hasVoted' => false], Response::HTTP_UNAUTHORIZED);
        }

        // Récupérer le build
        $build = $buildRepository->find($id);
        if (!$build) {
            return $this->json(['hasVoted' => false], Response::HTTP_NOT_FOUND);
        }

        // Vérifier si l'utilisateur a déjà voté pour ce build
        $existingVote = $voteRepository->findOneBy([
            'user' => $user,
            'build' => $build
        ]);

        return $this->json([
            'hasVoted' => $existingVote ? true : false,
        ], Response::HTTP_OK);
    }
    // #[Route('/vote/build/{id}', name: 'app_vote_build', methods: ['POST'])]
    // public function vote( int $id, BuildRepository $buildRepository, VoteRepository $voteRepository, EntityManagerInterface $entityManager, Request $request
    // ): Response {
    //     $user = $this->getUser();
    //     if (!$user) {
    //         return $this->redirectToRoute('app_login');
    //     }

    //     // recuperer le build par id
    //     $build = $buildRepository->find($id);
    //     if (!$build) {
    //         return $this->redirectToRoute('app_build_front_index');
    //     }

    //     // verification si vote dejà existant
    //     $existingVote = $voteRepository->findOneBy([
    //         'user' => $user,
    //         'build' => $build
    //     ]);

    //     // si exist deja on supprime le vote, si nouveau on enregistre
    //     if ($existingVote) {
    //         $entityManager->remove($existingVote);
    //         $entityManager->flush();
    //     } else {
    //         $vote = new Vote();
    //         $vote->setUser($user);
    //         $vote->setBuild($build);
    //         $vote->setVote(true); // true si c'est un like, false si c'est un dislike

    //         $entityManager->persist($vote);
    //         $entityManager->flush();
    //     }

    //     return $this->redirectToRoute('app_build_front_index', [], Response::HTTP_SEE_OTHER);
    // }
    #[Route('/vote/build/{id}', name: 'app_vote_build', methods: ['POST'])]
    public function vote( int $id, BuildRepository $buildRepository, VoteRepository $voteRepository, EntityManagerInterface $entityManager,): Response 
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->json(['error' => 'User not authenticated'], Response::HTTP_UNAUTHORIZED);
        }

        // recuperer le build par id
        $build = $buildRepository->find($id);
        if (!$build) {
            return $this->json(['error' => 'Build not found'], Response::HTTP_NOT_FOUND);
        }

        // verification si vote dejà existant
        $existingVote = $voteRepository->findOneBy([
            'user' => $user,
            'build' => $build
        ]);

        // si exist deja on supprime le vote, si nouveau on enregistre
        $voteStatus = 'added';
        if ($existingVote) {
            $entityManager->remove($existingVote);
            $entityManager->flush();
            $voteStatus = 'removed';
        } else {
            $vote = new Vote();
            $vote->setUser($user);
            $vote->setBuild($build);
            $vote->setVote(true);

            $entityManager->persist($vote);
            $entityManager->flush();
        }

        // reponse JSON pour AJAX
        return $this->json([
                'status' => 'success',
                'voteStatus' => $voteStatus,
            ], Response::HTTP_OK);
    }
}
