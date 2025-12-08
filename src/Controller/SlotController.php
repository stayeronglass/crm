<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Resource;
use App\Entity\Slot;
use App\Form\EventType;
use App\Form\SlotType;
use App\Repository\ResourceRepository;
use App\Repository\SlotRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
#[Route('/slot')]
#[IsGranted('ROLE_MANAGER')]
final class SlotController extends AbstractController
{
    #[Route(name: 'app_slot_index', methods: ['GET'])]
    public function index(ResourceRepository $repository, SlotRepository $slotRepository, EntityManagerInterface $em): Response
    {
        $m = $repository->findBy(['parent' => null]);

        $form = $this->createForm(SlotType::class, new Slot(),[
            'action' => $this->generateUrl('app_slot_add'),
            'method' => 'POST',
        ]);

        $res = $em->getRepository(Resource::class)->getResources();

        return $this->render('slot/index.html.twig', [
            'slots' => $slotRepository->findAll(),
            'form' =>$form,
            'resources' => $res,
            'm' => $m,
        ]);
    }
    #[Route(name: 'app_slot_add', methods: ['POST'])]
    public function add(Request $request, EntityManagerInterface $em)
    {
        $slot = new Slot();


        $form = $this->createForm(SlotType::class, $slot);
        $form->handleRequest($request);

        $current = $slot->getDateBegin();

        $repeat = !empty($form->get('dayOfWeek')->getData());
        if ($repeat) $repeatData = array_flip($form->get('dayOfWeek')->getData());

        while ($repeat && $current <= $slot->getDateEnd()){

            $dayOfWeekNumericISO = $current->format('N');
            if($repeatData[$dayOfWeekNumericISO] ?? false){
                $newSlot = clone $slot;
                dump($repeatData);
                dd($dayOfWeekNumericISO);

                $newSlot->setDateBegin($current->setTime($slot->getDateBegin()->format('H'),$slot->getDateBegin()->format('i')));
                $newSlot->setDateEnd($current->setTime($slot->getDateEnd()->format('H'),$slot->getDateEnd()->format('i')));

                $em->persist($newSlot);

            }



            $current = $current->add(new \DateInterval('P1D'));
        }

        dd('???');
        if (!$repeat) $em->persist($slot);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->flush();

            return new JsonResponse([
                'success' => true,
                'flashMessages' => ['Создано!']
            ]);
        }
        return $this->redirect('app_slot_index');
    }








    #[Route('/new', name: 'app_slot_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $slot = new Slot();
        $form = $this->createForm(SlotType::class, $slot);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($slot);
            $entityManager->flush();

            return $this->redirectToRoute('app_slot_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('slot/new.html.twig', [
            'slot' => $slot,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_slot_show', methods: ['GET'])]
    public function show(Slot $slot): Response
    {
        return $this->render('slot/show.html.twig', [
            'slot' => $slot,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_slot_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Slot $slot, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SlotType::class, $slot);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_slot_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('slot/edit.html.twig', [
            'slot' => $slot,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_slot_delete', methods: ['POST'])]
    public function delete(Request $request, Slot $slot, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$slot->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($slot);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_slot_index', [], Response::HTTP_SEE_OTHER);
    }
}
