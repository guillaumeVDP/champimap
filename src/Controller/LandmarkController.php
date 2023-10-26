<?php

namespace App\Controller;

use App\Entity\Landmark;
use App\Form\LandmarkType;
use App\Repository\LandmarkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/landmark')]
class LandmarkController extends AbstractController
{
    #[Route('/', name: 'app_landmark_index', methods: ['GET'])]
    public function index(LandmarkRepository $landmarkRepository): Response
    {
        return $this->render('landmark/index.html.twig', [
            'landmarks' => $landmarkRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_landmark_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $landmark = new Landmark();
        $form = $this->createForm(LandmarkType::class, $landmark, [
            'action' => $this->generateUrl('app_landmark_new'),
            'method' => 'POST',
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($landmark);
            $entityManager->flush();

            return $this->redirectToRoute('app_landmark_index', [], Response::HTTP_SEE_OTHER);
        }

        $template = $request->isXmlHttpRequest() ? '_form.html.twig' : 'new.html.twig';

        return $this->render('landmark/' . $template, [
            'landmark' => $landmark,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_landmark_show_full', methods: ['GET'])]
    public function show(Landmark $landmark): Response
    {
        return $this->render('landmark/show_full.html.twig', [
            'landmark' => $landmark,
        ]);
    }

    #[Route('/simple/{id}', name: 'app_landmark_show', methods: ['GET'])]
    public function showSimple(Landmark $landmark): Response
    {
        return $this->render('landmark/show.html.twig', [
            'landmark' => $landmark,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_landmark_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Landmark $landmark, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LandmarkType::class, $landmark);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_landmark_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('landmark/edit.html.twig', [
            'landmark' => $landmark,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_landmark_delete', methods: ['POST'])]
    public function delete(Request $request, Landmark $landmark, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $landmark->getId(), $request->request->get('_token'))) {
            $entityManager->remove($landmark);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_landmark_index', [], Response::HTTP_SEE_OTHER);
    }
}
