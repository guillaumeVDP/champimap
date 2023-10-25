<?php

namespace App\Controller;

use App\Repository\FindingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home', methods: ['GET'])]
    public function index(FindingRepository $findingRepository): Response
    {
        return $this->render('index.html.twig', [
            'findings' => $findingRepository->findAll(),
        ]);
    }

}
