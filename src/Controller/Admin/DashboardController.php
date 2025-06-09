<?php

namespace App\Controller\Admin;

use App\Entity\Author;
use App\Entity\Editor;
use App\Entity\Book;
use App\Entity\User;
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

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // 1.1) If you have enabled the "pretty URLs" feature:
        // return $this->redirectToRoute('admin_user_index');
        //
        // 1.2) Same example but using the "ugly URLs" that were used in previous EasyAdmin versions:
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirectToRoute('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Bookgest Administration');
    }

    public function configureMenuItems(): iterable
    {
    yield MenuItem::linkToRoute('Accueil', 'fa fa-home', 'admin');
    yield MenuItem::linkToDashboard('Dashboard', 'fa fa-gauge');

    yield MenuItem::section('GESTION');
    yield MenuItem::linkToCrud('Les auteurs', 'fas fa-user', Author::class);
    yield MenuItem::linkToCrud('Les livres', 'fas fa-book', Book::class);
    yield MenuItem::linkToCrud('Les éditeurs', 'fas fa-building', Editor::class);

    yield MenuItem::section('UTILISATEUR');
    yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-users', User::class);
    }
}
