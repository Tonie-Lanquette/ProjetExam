<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/create')]
class CreateController extends AbstractController
{
    #[Route(name: 'app_create_index')]
    public function index(): Response
    {
        return $this->render('front/create/index.html.twig', [
            'controller_name' => 'CreateController',
        ]);
    }
}
