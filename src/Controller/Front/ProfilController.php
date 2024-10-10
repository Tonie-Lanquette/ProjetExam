<?php

namespace App\Controller\Front;

use App\Form\ChangePasswordType;
use App\Repository\ArticleRepository;
use App\Repository\BuildRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[Route('/profil')]
class ProfilController extends AbstractController
{
    #[Route(name: 'app_profil_index')]
    public function index(BuildRepository $buildRepository, ArticleRepository $articleRepository): Response
    {

        $user = $this->getUser();

        $builds = $buildRepository->findBuildsByUser($user);
        $articles = $articleRepository->findArticlesByUser($user);

        return $this->render('front/profil/index.html.twig', [
            'user' => $user,
            'builds' => $builds,
            'articles' => $articles,
        ]);
    }

    #[Route('/change_password', name: 'app_change_password')]
    public function changePassword(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        if (!$user instanceof PasswordAuthenticatedUserInterface) {
            $this->addFlash('error', 'Vous devez être connecté pour changer votre mot de passe.');
            return $this->redirectToRoute('app_login');  
        }

        $form = $this->createForm(ChangePasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();
            $currentPassword = $data['currentPassword'];
            $newPassword = $data['newPassword'];
            $confirmationPassword = $data['confirmationPassword'];

            if (!$userPasswordHasher->isPasswordValid($user, $currentPassword)) {
                $this->addFlash('error', 'Current password is incorrect.');
                return $this->redirectToRoute('app_change_password');
            }

            if ($newPassword !== $confirmationPassword) {
                $this->addFlash('error', 'New password and confirmation do not match.');
                return $this->redirectToRoute('app_change_password');
            }

            $user->setPassword($userPasswordHasher->hashPassword($user, $newPassword));

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Your password has been changed successfully.');
            return $this->redirectToRoute('app_profil_index');
        }

        return $this->render('front/profil/password.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
