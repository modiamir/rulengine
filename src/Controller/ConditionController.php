<?php

namespace App\Controller;

use App\Entity\Condition;
use App\Entity\Rule;
use App\Form\ConditionType;
use App\Repository\ConditionRepository;
use App\RuleEngine\ConditionTypeFactory;
use App\RuleEngine\ContextDefinitionBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/rule/{rule}/condition")
 */
class ConditionController extends AbstractController
{
    /**
     * @Route("/", name="condition_index", methods={"GET"})
     */
    public function index(
        Rule $rule,
        ConditionRepository $conditionRepository,
        ConditionTypeFactory $conditionTypeFactory
    ) {
        $conditionTypes = array_keys($conditionTypeFactory->getConditionTypes());
        return $this->render('condition/index.html.twig', [
            'conditions' => $conditionRepository->findBy(['rule' => $rule]),
            'rule' => $rule,
            'condition_types' => $conditionTypes,
        ]);
    }

    /**
     * @Route("/new/{conditionType}", name="condition_new", methods={"GET","POST"})
     */
    public function new(Rule $rule, Request $request, $conditionType): Response
    {
        $condition = new Condition();
        $condition->setRule($rule);
        $condition->setCode($conditionType);
        $form = $this->createForm(ConditionType::class, $condition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($condition);
            $entityManager->flush();

            return $this->redirectToRoute('condition_index', ['rule' => $rule->getId()]);
        }

        return $this->render('condition/new.html.twig', [
            'condition' => $condition,
            'form' => $form->createView(),
            'rule' => $rule,
        ]);
    }

    /**
     * @Route("/{id}", name="condition_show", methods={"GET"})
     */
    public function show(Condition $condition): Response
    {
        return $this->render('condition/show.html.twig', [
            'condition' => $condition,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="condition_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Condition $condition, Rule $rule, ContextDefinitionBuilder $contextDefinitionBuilder): Response
    {
        $form = $this->createForm(ConditionType::class, $condition);
        $form->handleRequest($request);

        $contextDefinition = $contextDefinitionBuilder->buildForRule($rule);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('condition_index', [
                'id' => $condition->getId(),
                'rule' => $rule->getId()
            ]);
        }

        return $this->render('condition/edit.html.twig', [
            'condition' => $condition,
            'form' => $form->createView(),
            'rule' => $rule,
            'context' => $contextDefinition->availableDataPath(),
        ]);
    }

    /**
     * @Route("/{id}", name="condition_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Condition $condition, Rule $rule): Response
    {
        if ($this->isCsrfTokenValid('delete'.$condition->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($condition);
            $entityManager->flush();
        }

        return $this->redirectToRoute('condition_index', ['rule' => $rule->getId()]);
    }
}
