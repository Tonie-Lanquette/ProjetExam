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

            // Vérification si les champs password et confirmation sont vides
            if (empty($password) || empty($confirmationPassword)) {
                $this->addFlash('error', 'Password and confirmation password cannot be empty');
                return $this->redirectToRoute('app_register');
            }
            
             // Vérification si les passwords correspondent
            if ($password !== $confirmationPassword) {
                $this->addFlash('error', 'Password and confirmation password do not match');
                return $this->redirectToRoute('app_register');
            }

            // validation mdp avec une maj + chiffre + un special carctère
            if (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{8,}$/', $password)) {
                $this->addFlash('error', 'Password must be at least 8 characters long and include an uppercase letter, a lowercase letter, a number, and a special character.');
                return $this->redirectToRoute('app_register');
            }

            // Verifier la presence d'espace et mettre en minucsule
            $rawUsername = trim($form->get('username')->getData());
            $normalizedUsername = strtolower($rawUsername);

            // Comparer tout en minuscule pour éviter les doublons
            $existingUser = $entityManager->getRepository(User::class)->findOneBy(['username' => $normalizedUsername]);
            if ($existingUser) {
                $this->addFlash('error', 'This username is already taken');
                return $this->redirectToRoute('app_register');
            }

             // Enregistrement de l'utilisateur
            $user->setPassword($userPasswordHasher->hashPassword($user, $password))
            ->setUsername(strtolower(trim($form->get('username')->getData())))
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
