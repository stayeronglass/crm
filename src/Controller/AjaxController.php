<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Slot;
use App\Form\EventType;
use App\Form\SlotType;
use App\Repository\EventRepository;
use App\Repository\ResourceRepository;
use App\Repository\SlotRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[IsGranted('ROLE_USER')]
final class AjaxController extends AbstractController
{
    #[Route('/ajax/resources', name: 'app_ajax_resources')]
    public function resources(Request $request, ResourceRepository $repository): Response
    {
        return new JsonResponse($repository->getResources($request->get('id')));
    }

    #[Route('/ajax/events', name: 'app_ajax_events')]
    public function events(Request $request, EventRepository $repository, SlotRepository $slotRepository): Response
    {
        $events = $repository->getEvents($request->get('start'), $request->get('end'));
        $slots  = $slotRepository->getSlots($request->get('start'), $request->get('end'));
        $result = [];

        /** @var Slot $slot */
        foreach ($slots as $slot) {
            $resourceIds = [];
            foreach ($slot->getResources() as $resource) {
                $resourceIds[] = $resource->getId();
            }
            $result[] = [
                'id'              => $slot->getId(),
                'title'           => $slot->getTitle(),
                'start'           => $slot->getDateBegin()->format('Y-m-d H:i:s'),
                'end'             => $slot->getDateEnd()->format('Y-m-d H:i:s'),
                'resourceIds'     => $resourceIds,
                'backgroundColor' => $slot->getColor(),
                'editable'        => false,
                'display'         => 'background',
            ];
        }


        /** @var Event $event */
        foreach ($events as $event) {
            $result[] = [
                'id'              => $event->getId(),
                'title'           => $event->getService()->getTitle() . ': ' . $event->getComment(),
                'start'           => $event->getDateBegin()->format('Y-m-d H:i:s'),
                'end'             => $event->getDateEnd()->format('Y-m-d H:i:s'),
                'resourceIds'     => [$event->getResource()->getId()],
                'backgroundColor' => $event->getColor(),
                'editable'        => true,
            ];
        }

        return new JsonResponse($result);

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
                'success'       => true,
                'flashMessages' => ['Создано!']
            ]);
        }

        $errors = $this->getErrorsFromForm($form); // Call the helper method

        return new JsonResponse(
            [
                'success' => false,
                'type'    => 'validation_error',
                'title'   => 'There were validation errors.',
                'errors'  => $errors,
            ],
            Response::HTTP_BAD_REQUEST // 400 status code
        );
    }

    #[Route('/ajax/event/delete', name: 'app_ajax_event_delete', methods: ['POST'])]
    public function delete(Request $request, EntityManagerInterface $em): Response
    {
        $event = $em->getRepository(Event::class)->findOneBy(['slot' => $request->request->get('id')]);
        if (empty($event)) {
            return new JsonResponse([
                'success' => false,
                'errors'  => ['Событие не найдено!']
            ]);
        }
        $em->remove($event);
        $em->flush();


        return new JsonResponse([
            'success' => true,
            'flashMessages' => ['Удалено!']
        ]);
    }

    #[Route('/ajax/event/resize', name: 'app_ajax_event_resize')]
    public function resize(Request $request, EntityManagerInterface $em, ValidatorInterface $validator): JsonResponse
    {
        $event = $em->getRepository(Event::class)->find($request->request->get('id'));
        if (!$event) return new JsonResponse([
            'success' => false,
            'errors'  => ['Событие не найдено!'
            ]]);

        $begin = \DateTimeImmutable::createFromFormat(\DateTimeInterface::RFC3339_EXTENDED, $request->request->get('start'));;
        if (!$begin) return new JsonResponse([
            'success' => false,
            'errors'  => ['Неверная дата начала!'
            ]]);

        $end = \DateTimeImmutable::createFromFormat(\DateTimeInterface::RFC3339_EXTENDED, $request->request->get('end'));;
        if (!$end) return new JsonResponse([
            'success' => false,
            'errors'  => ['Неверная дата окончания!'
            ]]);

        $event
            ->setDateBegin($begin)
            ->setDateEnd($end)
        ;

        $errors = $validator->validate($event);

        if (count($errors) > 0) {
            $errorsMessage = [];
            // Handle validation errors (e.g., return a form with errors, or a JSON response)
            foreach ($errors as $violation) {
                $message = $violation->getMessage();
                $errorsMessage[] = $message;
            }
            return new JsonResponse([
                'success' => false,
                'errors'  => $errorsMessage
            ]);
        }

        $em->persist($event);
        $em->flush();


        return new JsonResponse(
            [
                'success'       => true,
                'flashMessages' => ['Обновлено!']
            ]
        );
    }


    #[Route('/ajax/event/{id}/edit', name: 'app_ajax_event_edit')]
    public function edit(Request $request, Event $event, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(EventType::class, $event);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($event);
            $em->flush();

            return new JsonResponse([
                'success'       => true,
                'flashMessages' => ['Обновлено!']
            ]);
        }

        $errors = $this->getErrorsFromForm($form); // Call the helper method

        return new JsonResponse(
            [
                'success' => false,
                'type'    => 'validation_error',
                'title'   => 'There were validation errors.',
                'errors'  => $errors,
            ],
            Response::HTTP_BAD_REQUEST // 400 status code
        );
    }
    private function getErrorsFromForm(FormInterface $form): array
    {
        $errors = [];
        foreach ($form->getErrors(true, false) as $error) {
            if ($error instanceof FormError) {
                $errors[] = $error->getMessage();
            }
        }

        foreach ($form->all() as $childForm) {
            if ($childForm instanceof FormInterface && !$childForm->isValid()) {
                $errors[$childForm->getName()] = $this->getErrorsFromForm($childForm);
            }
        }

        return $errors;
    }
}
