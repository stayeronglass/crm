<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Repository\ResourceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\ExpressionLanguage\Expression;
#[IsGranted(new Expression('is_granted("ROLE_MANAGER") or is_granted("ROLE_MASTER") or is_granted("ROLE_SELLER")'))]
final class EventController extends AbstractController
{
    #[Route('/events', name: 'app_events')]
    public function index(ResourceRepository $repository, EntityManagerInterface $em): Response
    {

        $form = $this->createForm(EventType::class, new Event(),[
            'action' => $this->generateUrl('app_ajax_events_add'),
            'method' => 'POST',
        ]);

        $repository->setChildrenIndex('children');
        $resources = [];
        $roots = $repository->getRootNodes();

        foreach ($roots as $r){
            $tree = $repository->childrenHierarchy(
                $r, /* starting node (null for entire tree) */
                false, /* direct children only */
                [], /* options */
                false /* include the root node in the result */
            );
            if (count($tree) == 0 ){
                $resources[] = [
                    'id' => $r->getId(),
                    'title' => $r->getTitle(),
                ];
            }
            foreach ($tree as $t){
                $t['title'] = $r->getTitle() . '/' . $t['title'] ;
                $resources[] = $t;
            }
        }

        return $this->render('event/index.html.twig', [
            'form' => $form,
            'resources' => $resources,
            'm' => $resources,
        ]);
    }
}
