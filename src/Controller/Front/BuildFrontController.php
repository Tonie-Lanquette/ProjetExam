<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/build')]
class BuildFrontController extends AbstractController
{
    #[Route(name: 'app_build_front_index')]
    public function index(): Response
    {
        return $this->render('front/build/index.html.twig', [
            'controller_name' => 'BuildFrontController',
        ]);
    }
}
