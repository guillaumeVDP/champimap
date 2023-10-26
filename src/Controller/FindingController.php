<?php

namespace App\Controller;

use App\Entity\Finding;
use App\Form\FindingType;
use App\Repository\FindingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/finding')]
class FindingController extends AbstractController
{
    #[Route('/', name: 'app_finding_index', methods: ['GET'])]
    public function index(FindingRepository $findingRepository): Response
    {
        return $this->render('finding/index.html.twig', [
            'findings' => $findingRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_finding_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $finding = new Finding();
        $form = $this->createForm(FindingType::class, $finding, [
            'action' => $this->generateUrl('app_finding_new'),
            'method' => 'POST',
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($finding);
            $entityManager->flush();

            return $this->redirectToRoute('app_finding_index', [], Response::HTTP_SEE_OTHER);
        }

        $template = $request->isXmlHttpRequest() ? '_form.html.twig' : 'new.html.twig';

        return $this->render('finding/' . $template, [
            'finding' => $finding,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_finding_show_full', methods: ['GET'])]
    public function show(Finding $finding): Response
    {
        return $this->render('finding/show_full.html.twig', [
            'finding' => $finding,
        ]);
    }

    #[Route('/simple/{id}', name: 'app_finding_show', methods: ['GET'])]
    public function showSimple(Finding $finding): Response
    {
        return $this->render('finding/show.html.twig', [
            'finding' => $finding,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_finding_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Finding $finding, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FindingType::class, $finding);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_finding_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('finding/edit.html.twig', [
            'finding' => $finding,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_finding_delete', methods: ['POST'])]
    public function delete(Request $request, Finding $finding, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $finding->getId(), $request->request->get('_token'))) {
            $entityManager->remove($finding);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_finding_index', [], Response::HTTP_SEE_OTHER);
    }
}
