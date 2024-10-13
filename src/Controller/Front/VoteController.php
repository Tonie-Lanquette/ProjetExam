<?php

namespace App\Controller\Front;

use App\Entity\Vote;
use App\Repository\BuildRepository;
use App\Repository\VoteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class VoteController extends AbstractController
{
    #[Route('/vote/build/{id}', name: 'app_vote_build', methods: ['POST'])]
    public function vote( int $id, BuildRepository $buildRepository, VoteRepository $voteRepository, EntityManagerInterface $entityManager, Request $request
    ): Response {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        // recuperer le build par id
        $build = $buildRepository->find($id);
        if (!$build) {
            return $this->redirectToRoute('app_build_front_index');
        }

        // verification si vote dejà existant
        $existingVote = $voteRepository->findOneBy([
            'user' => $user,
            'build' => $build
        ]);

        // si exist deja on supprime le vote, si nouveau on enregistre
        if ($existingVote) {
            $entityManager->remove($existingVote);
            $entityManager->flush();
        } else {
            $vote = new Vote();
            $vote->setUser($user);
            $vote->setBuild($build);
            $vote->setVote(true); // true si c'est un like, false si c'est un dislike

            $entityManager->persist($vote);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_build_front_index', [], Response::HTTP_SEE_OTHER);
    }
}
