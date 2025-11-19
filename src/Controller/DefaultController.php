<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventRepository;
use App\Repository\ResourceRepository;
use App\Repository\SlotRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DefaultController extends AbstractController
{
    public function header(Request $request): Response
    {
        return $this->render('default/header.html.twig', [
        ]);
    }

    public function footer(Request $request): Response
    {
        return $this->render('default/footer.html.twig', [
        ]);
    }

    #[Route('/', name: 'app_default')]
    public function index(ResourceRepository $repository): Response
    {
        $m = $repository->findBy(['parent' => null]);
        $form = $this->createForm(EventType::class, new Event(),[
            'action' => $this->generateUrl('app_ajax_events_add'),
            'method' => 'POST',
            ]);

        $res = $repository->getResources();
        return $this->render('default/index.html.twig', [
            'form' => $form,
            'resources' => $res,
            'm' => $m,
        ]);
    }

    #[Route('/booking/{id}', name: 'app_booking')]
    public function books(Request $request, ResourceRepository $repository): Response
    {
        if(!$request->get('id')) throw $this->createNotFoundException();

        $m = $repository->findBy(['parent' => $request->get('id')]);

        return $this->render('default/booking.html.twig', [
            'm' => $m,
        ]);
    }

    #[Route('/booking2/{id}', name: 'app_booking2')]
    public function books2(Request $request, ResourceRepository $repository): Response
    {
        if(!$request->get('id')) throw $this->createNotFoundException();

        $m = $repository->findBy(['parent' => $request->get('id')]);

        return $this->render('default/booking2.html.twig', [
            'm' => $m,
        ]);
    }
}
