<?php

namespace App\Controller;

use App\Repository\FindingRepository;
use App\Repository\LandmarkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home', methods: ['GET'])]
    public function index(
        FindingRepository  $findingRepository,
        LandmarkRepository $landmarkRepository,
    ): Response
    {
        return $this->render('index.html.twig', [
            'findings' => $findingRepository->findAll(),
            'landmarks' => $landmarkRepository->findAll(),
        ]);
    }

}
