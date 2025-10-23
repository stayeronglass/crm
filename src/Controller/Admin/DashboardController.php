<?php

namespace App\Controller\Admin;

use App\Entity\Slot;
use App\Entity\Filter;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Chalet CRM')
            ;
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::section('Products', 'admin');
        yield MenuItem::linkToCrud('Мастерские', 'fa fa-tags', Filter::class);
        yield MenuItem::linkToCrud('Услуги', 'fa fa-tags', Filter::class);
        yield MenuItem::linkToCrud('Слоты', 'fa fa-tags', Slot::class);

        //yield MenuItem::linkToLogout('Logout', 'fa fa-exit');
    }
}
