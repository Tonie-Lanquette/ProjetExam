<?php

namespace App\Controller\Front;

use App\Repository\BuildRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/build')]
class BuildFrontController extends AbstractController
{
    #[Route('s' , name: 'app_build_front_index')]
    public function index(BuildRepository $buildRepository): Response
    {
        $builds = $buildRepository->findAll();
        // dd($builds);

        return $this->render('front/build/index.html.twig', [
            'builds' => $builds
        ]);
    }
}
