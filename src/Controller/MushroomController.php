<?php

namespace App\Controller;

use App\Entity\Mushroom;
use App\Form\MushroomType;
use App\Repository\MushroomRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/mushroom')]
class MushroomController extends AbstractController
{
    #[Route('/', name: 'app_mushroom_index', methods: ['GET'])]
    public function index(MushroomRepository $mushroomRepository): Response
    {
        return $this->render('mushroom/index.html.twig', [
            'mushrooms' => $mushroomRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_mushroom_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $mushroom = new Mushroom();
        $form = $this->createForm(MushroomType::class, $mushroom);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($mushroom);
            $entityManager->flush();

            return $this->redirectToRoute('app_mushroom_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('mushroom/new.html.twig', [
            'mushroom' => $mushroom,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_mushroom_show', methods: ['GET'])]
    public function show(Mushroom $mushroom): Response
    {
        return $this->render('mushroom/show.html.twig', [
            'mushroom' => $mushroom,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_mushroom_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Mushroom $mushroom, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MushroomType::class, $mushroom);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_mushroom_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('mushroom/edit.html.twig', [
            'mushroom' => $mushroom,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_mushroom_delete', methods: ['POST'])]
    public function delete(Request $request, Mushroom $mushroom, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $mushroom->getId(), $request->request->get('_token'))) {
            $entityManager->remove($mushroom);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_mushroom_index', [], Response::HTTP_SEE_OTHER);
    }
}
