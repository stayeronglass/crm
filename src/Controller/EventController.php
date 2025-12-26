<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Form\SlotType;
use App\Repository\EventRepository;
use App\Repository\ResourceRepository;
use App\Repository\SlotRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\ExpressionLanguage\Expression;
#[IsGranted(new Expression('is_granted("ROLE_MANAGER") or is_granted("ROLE_MASTER") or is_granted("ROLE_SELLER")'))]
final class EventController extends AbstractController
{
    #[Route('/events', name: 'app_events')]
    public function index(ResourceRepository $repository): Response
    {

        $form = $this->createForm(EventType::class, new Event(),[
            'action' => $this->generateUrl('app_ajax_events_add'),
            'method' => 'POST',
        ]);

        $root = $repository->find(1);
        $res  = $repository->getLeafsQuery($root)->getArrayResult();

        return $this->render('event/index.html.twig', [
            'form' => $form,
            'resources' => $res,
        ]);
    }

    #[Route('/form_edit', name: 'app_event_form_edit', methods: ['GET', 'POST'])]
    public function form_edit(EventRepository $repository, Request $request): Response
    {
        $event = $repository->find($request->request->get('id'));
        $form = $this->createForm(EventType::class, $event, [
            'action' => $this->generateUrl('app_ajax_event_edit', ['id' => $event->getId()]),
            'method' => 'POST',
        ]);

        $result = $this->renderView('event/_form_edit.html.twig', [
            'form' => $form,
        ]);

        return new Response($result, Response::HTTP_OK);
    }
}
