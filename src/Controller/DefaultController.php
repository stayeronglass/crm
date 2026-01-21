<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Slot;
use App\Form\EventType;
use App\Repository\EventRepository;
use App\Repository\ResourceRepository;
use App\Repository\SlotRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use function Symfony\Component\Clock\now;

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
    public function index(ResourceRepository $repository, EntityManagerInterface $em): Response
    {
        return $this->render('default/index.html.twig', [
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
