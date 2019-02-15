<?php

namespace App\Controller;

use App\Entity\Action;
use App\Entity\Rule;
use App\Form\ActionType;
use App\Repository\ActionRepository;
use App\RuleEngine\ActionTypeFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("rule/{rule}/action")
 */
class ActionController extends AbstractController
{
    /**
     * @Route("/", name="action_index", methods={"GET"})
     */
    public function index(Rule $rule, ActionTypeFactory $actionTypeFactory): Response
    {
        $actionTypes = $actionTypeFactory->getActionTypeCodes();
        return $this->render('action/index.html.twig', [
            'actions' => $rule->getActions(),
            'rule' => $rule,
            'action_types' => $actionTypes,
        ]);
    }

    /**
     * @Route("/new/{actionType}", name="action_new", methods={"GET","POST"})
     */
    public function new(Request $request, Rule $rule, $actionType): Response
    {
        $action = new Action();
        $action->setRule($rule);
        $action->setCode($actionType);
        $form = $this->createForm(ActionType::class, $action);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($action);
            $entityManager->flush();

            return $this->redirectToRoute('action_index', [
                'rule' => $rule->getId(),
            ]);
        }

        return $this->render('action/new.html.twig', [
            'action' => $action,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="action_show", methods={"GET"})
     */
    public function show(Action $action): Response
    {
        return $this->render('action/show.html.twig', [
            'action' => $action,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="action_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Action $action): Response
    {
        $form = $this->createForm(ActionType::class, $action);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('action_index', [
                'id' => $action->getId(),
                'rule' => $action->getRule()->getId(),
            ]);
        }

        return $this->render('action/edit.html.twig', [
            'action' => $action,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="action_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Action $action): Response
    {
        if ($this->isCsrfTokenValid('delete'.$action->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($action);
            $entityManager->flush();
        }

        return $this->redirectToRoute('action_index', ['rule' => $action->getRule()->getId()]);
    }
}
