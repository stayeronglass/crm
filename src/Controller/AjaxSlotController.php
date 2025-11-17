<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Slot;
use App\Repository\SlotRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
        /** @var Slot $event */
        foreach ($slots as $slot) {
            $result[] = [
                'id' => $slot->getId(),
                'title' => $slot->getService()->getTitle() . ': ' . $slot->getComment(),
                'start' => $slot->getDateBegin()->format('Y-m-d H:i:s'),
                'end' => $slot->getDateEnd()->format('Y-m-d H:i:s'),
                'resourceIds' => [$slot->getResource()->getId()]
            ];
        }

        return new JsonResponse($result);

    }
}
