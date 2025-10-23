<?php

namespace App\Controller;

use App\Entity\Filter;
use App\Form\FilterType;
use App\Repository\FilterRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/filter')]
final class FilterController extends AbstractController
{
    #[Route(name: 'app_filter_index', methods: ['GET'])]
    public function index(FilterRepository $filterRepository): Response
    {
        return $this->render('filter/index.html.twig', [
            'filters' => $filterRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_filter_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $filter = new Filter();
        $form = $this->createForm(FilterType::class, $filter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($filter);
            $entityManager->flush();

            return $this->redirectToRoute('app_filter_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('filter/new.html.twig', [
            'filter' => $filter,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_filter_show', methods: ['GET'])]
    public function show(Filter $filter): Response
    {
        return $this->render('filter/show.html.twig', [
            'filter' => $filter,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_filter_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Filter $filter, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FilterType::class, $filter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_filter_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('filter/edit.html.twig', [
            'filter' => $filter,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_filter_delete', methods: ['POST'])]
    public function delete(Request $request, Filter $filter, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$filter->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($filter);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_filter_index', [], Response::HTTP_SEE_OTHER);
    }
}
