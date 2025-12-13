<?php

namespace App\Controller\Admin;

use App\Entity\Event;
use App\Entity\Resource;
use App\Entity\Service;
use App\Entity\Slot;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{

    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Chalet CRM')
            ;
    }
    public function configureCrud(): Crud
    {
         return Crud::new()
            ->setDateTimeFormat('dd.MM.yyyy HH:mm')
             //self::PAGE_DETAIL, self::PAGE_EDIT, self::PAGE_INDEX, self::PAGE_NEW
            //->setPageTitle(Crud::PAGE_INDEX, 'Chalet CRM | Dashboard')
            //->setPageTitle(Crud::PAGE_DETAIL, 'Chalet CRM | View Item')
         ;
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Главная', 'fa fa-home');

        yield MenuItem::section('CRM', 'admin');
        yield MenuItem::linkToCrud('Мастерские', 'fa fa-tags', Resource::class);
        yield MenuItem::linkToCrud('Услуги', 'fa fa-tags', Service::class);
        yield MenuItem::linkToCrud('Слоты', 'fa fa-tags', Slot::class);
        yield MenuItem::linkToCrud('Записи', 'fa fa-clock', Event::class);
        yield MenuItem::linkToCrud('Пользователи', 'fa fa-user', User::class);

        yield MenuItem::section('Служебные', 'admin');
        yield MenuItem::linkToLogout('Выход', 'fa fa-sign-out');
    }
}
