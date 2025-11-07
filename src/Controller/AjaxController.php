<?php

namespace App\Controller;

use App\Repository\FilterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AjaxController extends AbstractController
{
    #[Route('/ajax/resources', name: 'app_ajax_resources')]
    public function index(Request $request, FilterRepository $repository): Response
    {
        return new JsonResponse($repository->getResources($request->get('id')));
    }
}
