<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Slot;
use App\Form\EventType;
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

final class AjaxSlotController extends AbstractController
{
    #[Route('/ajax/slot', name: 'app_ajax_slot')]
    public function events(Request $request, SlotRepository $repository): Response
    {
        $slots = $repository->getSlots($request->get('start'), $request->get('end'));


        $result = [];
        /** @var Slot $slot */
        foreach ($slots as $slot) {
            $result[] = [
                'id' => $slot->getId(),
                'title' => $slot->getService()->getTitle() . ': ' . $slot->getDescription(),
                'start' => $slot->getDateBegin()->format('Y-m-d H:i:s'),
                'end' => $slot->getDateEnd()->format('Y-m-d H:i:s'),
                'resourceIds' => [$slot->getResource()->getId()]
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
            if ($error instanceof FormError)
            {
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
