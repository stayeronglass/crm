<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventRepository;
use App\Repository\ResourceRepository;
use App\Repository\SlotRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use function Symfony\Component\Clock\now;

final class AjaxController extends AbstractController
{
    #[Route('/ajax/resources', name: 'app_ajax_resources')]
    public function resources(Request $request, ResourceRepository $repository): Response
    {
        return new JsonResponse($repository->getResources($request->get('id')));
    }

    #[Route('/ajax/events', name: 'app_ajax_events')]
    public function events(Request $request, EventRepository $repository): Response
    {
        $events = $repository->getEvents($request->get('start'), $request->get('end'));


        $result = [];
        /** @var Event $event */
        foreach ($events as $event) {
            $result[] = [
                'id' => $event->getId(),
                'title' => $event->getService()->getTitle() . ': ' . $event->getComment(),
                'start' => $event->getDateBegin()->format('Y-m-d H:i:s'),
                'end' => $event->getDateEnd()->format('Y-m-d H:i:s'),
                'resourceIds' => [$event->getResource()->getId()]
            ];
        }

        return new JsonResponse($result);
//        return new JsonResponse(
//            '[
//            {"start":"2025-11-13 1:00:00","end":"2025-11-13 2:00:00","resourceIds":[1],  "title": "Editable Event"},
//            {"start":"2025-11-13 2:00:00","end":"2025-11-13 3:00:00","resourceIds":[2],  "title": "Editable Event"}
//            ]',
//            200, [], true
//        );
    }

    #[Route('/ajax/events/add', name: 'app_ajax_events_add')]
    public function eventsAdd(Request $request, EntityManagerInterface $em): Response
    {
        $event = new Event();

        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($event);
            $em->flush();

            return new JsonResponse([
                'success' => true,
                'flashMessages' => ['Создано!']
            ]);
        }

        $errors = $this->getErrorsFromForm($form); // Call the helper method

        return new JsonResponse(
            [
                'success' => false,
                'type' => 'validation_error',
                'title' => 'There were validation errors.',
                'errors' => $errors,
            ],
            Response::HTTP_BAD_REQUEST // 400 status code
        );
    }

    private function getErrorsFromForm(FormInterface $form): array
    {
        $errors = [];
        foreach ($form->getErrors(true, false) as $error) {
            $errors[] = $error->getMessage();
        }

        foreach ($form->all() as $childForm) {
            if ($childForm instanceof FormInterface && !$childForm->isValid()) {
                $errors[$childForm->getName()] = $this->getErrorsFromForm($childForm);
            }
        }

        return $errors;
    }
}
