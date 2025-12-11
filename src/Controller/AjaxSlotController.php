<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Slot;
use App\Form\SlotType;
use App\Repository\SlotRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class AjaxSlotController extends AbstractController
{
    #[Route('/ajax/slot', name: 'app_ajax_slot')]
    public function slots(Request $request, SlotRepository $repository): Response
    {
        $slots = $repository->getSlots($request->get('start'), $request->get('end'));

        $result = [];
        /** @var Slot $slot */
        foreach ($slots as $slot) {
            $resourceIds = [];
            foreach ($slot->getResources() as $resource) {
                $resourceIds[] = $resource->getId();
            }
            $result[] = [
                'id'              => $slot->getId(),
                'title'           => $slot->getTitle() . ': ' . $slot->getDescription(),
                'start'           => $slot->getDateBegin()->format('Y-m-d H:i:s'),
                'end'             => $slot->getDateEnd()->format('Y-m-d H:i:s'),
                'resourceIds'     => $resourceIds,
                'backgroundColor' => $slot->getColor(),
                //'display' => 'background',
                'editable'        => true,
            ];
        }

        return new JsonResponse($result);

    }

    #[Route('/ajax/slot/add', name: 'app_ajax_slot_add')]
    public function eventsAdd(Request $request, EntityManagerInterface $em): Response
    {
        $slot = new Slot();

        $form = $this->createForm(SlotType::class, $slot);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($slot);
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

    #[Route('/ajax/slot/delete', name: 'app_ajax_slot_delete', methods: ['POST'])]
    public function delete(Request $request, EntityManagerInterface $em): Response
    {
        $slot = $em->getRepository(Slot::class)->find($request->request->get('id'));
        $event = $em->getRepository(Event::class)->findOneBy(['slot' => $slot->getId()]);
        if (!empty($event)) {
            return new JsonResponse([
                'success' => false,
                'errors'  => ['К слоту уже привязано событие!']
            ]);
        }
        $em->remove($slot);
        $em->flush();


        return new JsonResponse([
            'success' => true,
            'flashMessages' => ['Удалено!']
        ]);
    }

    #[Route('/ajax/slot/resize', name: 'app_ajax_slot_resize')]
    public function resize(Request $request, EntityManagerInterface $em, ValidatorInterface $validator): JsonResponse
    {
        $slot = $em->getRepository(Slot::class)->find($request->request->get('id'));
        if (!$slot) return new JsonResponse([
            'success' => false,
            'errors'  => ['Нет такого слота!'
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

        $slot
            ->setDateBegin($begin)
            ->setDateEnd($end)
        ;

        $errors = $validator->validate($slot);

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

        $em->persist($slot);
        $em->flush();


        return new JsonResponse(
            [
                'success'       => true,
                'flashMessages' => ['Обновлено!']
            ]
        );
    }

    #[Route('/ajax/slot/{id}/edit', name: 'app_ajax_slot_edit')]
    public function edit(Request $request, Slot $slot, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(SlotType::class, $slot);
        $form->remove('dayOfWeek');

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($slot);
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
}
