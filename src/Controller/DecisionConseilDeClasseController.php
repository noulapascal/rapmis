<?php

namespace App\Controller;

use App\Entity\DecisionConseilDeClasse;
use App\Form\DecisionConseilDeClasse1Type;
use App\Repository\DecisionConseilDeClasseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/decision/conseil/de/classe")
 */
class DecisionConseilDeClasseController extends AbstractController
{
    /**
     * @Route("/", name="decision_conseil_de_classe_index", methods={"GET"})
     */
    public function index(DecisionConseilDeClasseRepository $decisionConseilDeClasseRepository): Response
    {
        return $this->render('decision_conseil_de_classe/index.html.twig', [
            'decision_conseil_de_classes' => $decisionConseilDeClasseRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="decision_conseil_de_classe_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $decisionConseilDeClasse = new DecisionConseilDeClasse();
        $form = $this->createForm(DecisionConseilDeClasse1Type::class, $decisionConseilDeClasse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($decisionConseilDeClasse);
            $entityManager->flush();

            return $this->redirectToRoute('decision_conseil_de_classe_index');
        }

        return $this->render('decision_conseil_de_classe/new.html.twig', [
            'decision_conseil_de_classe' => $decisionConseilDeClasse,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="decision_conseil_de_classe_show", methods={"GET"})
     */
    public function show(DecisionConseilDeClasse $decisionConseilDeClasse): Response
    {
        return $this->render('decision_conseil_de_classe/show.html.twig', [
            'decision_conseil_de_classe' => $decisionConseilDeClasse,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="decision_conseil_de_classe_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, DecisionConseilDeClasse $decisionConseilDeClasse): Response
    {
        $form = $this->createForm(DecisionConseilDeClasse1Type::class, $decisionConseilDeClasse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('decision_conseil_de_classe_index');
        }

        return $this->render('decision_conseil_de_classe/edit.html.twig', [
            'decision_conseil_de_classe' => $decisionConseilDeClasse,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="decision_conseil_de_classe_delete", methods={"DELETE"})
     */
    public function delete(Request $request, DecisionConseilDeClasse $decisionConseilDeClasse): Response
    {
        if ($this->isCsrfTokenValid('delete'.$decisionConseilDeClasse->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($decisionConseilDeClasse);
            $entityManager->flush();
        }

        return $this->redirectToRoute('decision_conseil_de_classe_index');
    }
}
