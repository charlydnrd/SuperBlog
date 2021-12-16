<?php

namespace App\Controller;

use App\Entity\BlogMessage;
use App\Form\BlogMessageType;
use App\Repository\BlogMessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/blog/message")
 */
class BlogMessageController extends AbstractController
{
    /**
     * @Route("/", name="blog_message_index", methods={"GET"})
     */
    public function index(BlogMessageRepository $blogMessageRepository): Response
    {
        return $this->render('blog_message/index.html.twig', [
            'blog_messages' => $blogMessageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="blog_message_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $blogMessage = new BlogMessage();
        $form = $this->createForm(BlogMessageType::class, $blogMessage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($blogMessage);
            $entityManager->flush();

            return $this->redirectToRoute('blog_message_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('blog_message/new.html.twig', [
            'blog_message' => $blogMessage,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="blog_message_show", methods={"GET"})
     */
    public function show(BlogMessage $blogMessage): Response
    {
        return $this->render('blog_message/show.html.twig', [
            'blog_message' => $blogMessage,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="blog_message_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, BlogMessage $blogMessage): Response
    {
        $form = $this->createForm(BlogMessageType::class, $blogMessage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('blog_message_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('blog_message/edit.html.twig', [
            'blog_message' => $blogMessage,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="blog_message_delete", methods={"POST"})
     */
    public function delete(Request $request, BlogMessage $blogMessage): Response
    {
        if ($this->isCsrfTokenValid('delete'.$blogMessage->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($blogMessage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('blog_message_index', [], Response::HTTP_SEE_OTHER);
    }
}
