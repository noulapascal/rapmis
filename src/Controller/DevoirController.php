<?php

namespace App\Controller;

use App\Entity\Devoir;
use App\Form\Devoir1Type;
use App\Repository\DevoirRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/devoir")
 */
class DevoirController extends AbstractController
{
    /**
     * @Route("/", name="devoir_index", methods={"GET"})
     */
    public function index(DevoirRepository $devoirRepository): Response
    {
        return $this->render('devoir/index.html.twig', [
            'devoirs' => $devoirRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="devoir_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $devoir = new Devoir();
        $form = $this->createForm(Devoir1Type::class, $devoir);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($devoir);
            $entityManager->flush();

            return $this->redirectToRoute('devoir_index');
        }

        return $this->render('devoir/new.html.twig', [
            'devoir' => $devoir,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="devoir_show", methods={"GET"})
     */
    public function show(Devoir $devoir): Response
    {
        return $this->render('devoir/show.html.twig', [
            'devoir' => $devoir,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="devoir_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Devoir $devoir): Response
    {
        $form = $this->createForm(Devoir1Type::class, $devoir);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('devoir_index');
        }

        return $this->render('devoir/edit.html.twig', [
            'devoir' => $devoir,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="devoir_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Devoir $devoir): Response
    {
        if ($this->isCsrfTokenValid('delete'.$devoir->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($devoir);
            $entityManager->flush();
        }

        return $this->redirectToRoute('devoir_index');
    }
}
