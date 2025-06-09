<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/author', name: 'app_admin_author')]
final class AuthorController extends AbstractController
{
    #[IsGranted('IS_AUTHENTICATED')]
    #[Route('/', name: 'app_admin_author_index', methods: ['GET'])]
    public function index(Request $request, AuthorRepository $authorRepository): Response
    {
        $dates = [
            'start' => $request->query->get('start'),
            'end' => $request->query->get('end'),
        ];

        $authors = $authorRepository->findByDateOfBirth($dates);

        return $this->render('admin/author/index.html.twig', [
            'authors' => $authors,
        ]);
    }

    #[IsGranted('IS_AUTHENTICATED')]
    #[Route('/new', name: '_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $author = new Author();
        $form = $this->createForm(AuthorType::class, $author);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($author); // Add the new Author entity to the EntityManager
            $em->flush(); // Flush the changes to the database

            return $this->redirectToRoute('app_admin_author_new');
        }

        return $this->render('admin/author/new.html.twig', [
            'author_form' => $form,
        ]);
    }
    #[Route('/{id}', name: '_show', methods: ['GET'])]
    public function show(?Author $author): Response
    {
        return $this->render('admin/author/show.html.twig', [
            'author' => $author,
        ]);
    }

    #[Route('/{id}/edit', name: '_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Author $author, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('app_admin_author_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('admin/author/edit.html.twig', ['author' => $author, 'form' => $form,]);
    }
}
