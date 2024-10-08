<?php

namespace App\Controller\Security;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, Security $security, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $password = $form->get('plainPassword')->getData();
            $confirmationPassword = $form->get('confirmationPassword')->getData();
            if ($password !== $confirmationPassword) {
                $this->addFlash('error', 'Password and confirmation password do not match');
                return $this->redirectToRoute('app_register');
            }
            $plainPassword = $form->get('plainPassword')->getData();
            
            $user->setPassword($userPasswordHasher->hashPassword($user, $plainPassword))
            ->setRoles(['ROLE_USER'])
            ->setGdpr(new \DateTimeImmutable())
            ->setCreated(new \DateTimeImmutable())
            ->setUpdated(new \DateTimeImmutable());

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Your account has been successfully created');
            return $security->login($user, 'form_login', 'main');
        }

        return $this->render('security/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }
}
