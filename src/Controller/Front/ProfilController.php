<?php

namespace App\Controller\Front;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/profil')]
class ProfilController extends AbstractController
{
    #[Route(name: 'app_profil_index')]
    public function index(): Response
    {

        $user = $this->getUser();

        return $this->render('front/profil/index.html.twig', [
            'user' => $user,
        ]);
    }
}
