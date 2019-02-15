<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 2/14/19
 * Time: 8:40 PM
 */

namespace App\RuleEngine\Messenger;


use App\Entity\Condition;
use App\Entity\Rule;
use App\Repository\RuleRepository;
use App\RuleEngine\ActionTypeFactory;
use App\RuleEngine\ConditionTypeFactory;
use App\RuleEngine\Context;
use App\RuleEngine\Events\AsdEventType;
use App\RuleEngine\Events\OrderSubmitted\OrderSubmittedEventType;
use App\RuleEngine\EventTypeFactory;
use App\RuleEngine\ValueResolver;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class RuleEngineHandler implements MessageHandlerInterface
{
    /**
     * @var RuleRepository
     */
    private $ruleRepository;
    /**
     * @var ConditionTypeFactory
     */
    private $conditionTypeFactory;
    /**
     * @var ActionTypeFactory
     */
    private $actionTypeFactory;

    public function __construct(
        RuleRepository $ruleRepository,
        ConditionTypeFactory $conditionTypeFactory,
        ActionTypeFactory $actionTypeFactory
    ) {
        $this->ruleRepository = $ruleRepository;
        $this->conditionTypeFactory = $conditionTypeFactory;
        $this->actionTypeFactory = $actionTypeFactory;
    }

    public function __invoke(RuleEngineMessage $message)
    {
        $rules = $this->ruleRepository->findAll();

        foreach ($rules as $rule) {
            if ($rule->getEvent()->getCode() == $message->getEvent()) {
                $eventTypeFactory = new EventTypeFactory();
                $eventTypeFactory->registerEvent('asd', AsdEventType::class);
                $eventTypeFactory->registerEvent('order_submitted', OrderSubmittedEventType::class);

                $eventType = $eventTypeFactory->createEvent($message->getEvent());
                $context = new Context();
                $resultDefinition = $eventType->getResultDefinition();
                $resultData = $eventType->getResultData($message->getData());
                foreach ($resultDefinition as $name => $type) {
                    if (isset($resultData[$name]) && (gettype($resultData[$name]) === $type || $resultData[$name] instanceof $type)) {
                        $context->add("{$message->getEvent()}__$name", $resultData[$name]);
                    } else {
                        throw new \InvalidArgumentException('wrong event result data');
                    }
                }
                $isConditionsValid = $this->isConditionsValid($rule, $context);

                if (!$isConditionsValid) {
                    continue;
                }

                $actions = $rule->getActions();

                foreach ($actions as $action) {
                    $actionType = $this->actionTypeFactory->getActionType($action->getCode());
                    $resultDefinition = $actionType->getResultDefinition();
                    $resultData = $actionType->perform(new ValueResolver($context, $action->getParameters()));
                    foreach ($resultDefinition as $name => $type) {
                        if (isset($resultData[$name]) && (gettype($resultData[$name]) === $type || $resultData[$name] instanceof $type)) {
                            $context->add($name, $resultData[$name]);
                        } else {
                            throw new \InvalidArgumentException('wrong event result data');
                        }
                    }
                }
            }
        }
    }

    private function isConditionsValid(Rule $rule, Context $context)
    {
        $conditions = $rule->getConditions();
        foreach ($conditions as $condition) {
            $conditionType = $this->conditionTypeFactory->createConditionType($condition->getCode());
            if (!$conditionType->evaluate(new ValueResolver($context, $condition->getParameters()))) {
                return false;
            }
        }

        return true;
    }
}
