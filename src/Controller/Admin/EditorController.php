<?php

namespace App\Controller\Admin;

use App\Entity\Editor;
use App\Form\EditorType;
use App\Repository\EditorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/editor', name:'app_admin_editor')]
final class EditorController extends AbstractController
{
    #[Route(name: '_index', methods: ['GET'])]
    public function index(EditorRepository $editorRepository): Response
    {
        return $this->render('admin/editor/index.html.twig', [
            'editors' => $editorRepository->findAll(),
        ]);
    }

    #[Route('/new', name: '_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $editor = new Editor();
        $form = $this->createForm(EditorType::class, $editor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($editor);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_editor_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/editor/new.html.twig', [
            'editor' => $editor,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: '_show', methods: ['GET'])]
    public function show(Editor $editor): Response
    {
        return $this->render('admin/editor/show.html.twig', [
            'editor' => $editor,
        ]);
    }

    #[Route('/{id}/edit', name: '_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Editor $editor, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EditorType::class, $editor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_editor_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/editor/edit.html.twig', [
            'editor' => $editor,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: '_delete', methods: ['POST'])]
    public function delete(Request $request, Editor $editor, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$editor->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($editor);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_editor_index', [], Response::HTTP_SEE_OTHER);
    }
}
