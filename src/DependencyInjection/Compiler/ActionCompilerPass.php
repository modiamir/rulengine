<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 2/15/19
 * Time: 5:42 PM
 */

namespace App\DependencyInjection\Compiler;


use App\RuleEngine\ActionTypeFactory;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ActionCompilerPass implements CompilerPassInterface
{

    /**
     * You can modify the container here before it is dumped to PHP code.
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition(ActionTypeFactory::class)) {
            return;
        }

        $actionTypeFactoryDefinition = $container->getDefinition(ActionTypeFactory::class);

        $taggedServices = $container->findTaggedServiceIds('action_type');

        foreach ($taggedServices as $id => $tags) {
            $code = $tags[0]['code'];
            $actionTypeFactoryDefinition->addMethodCall('registerActionType', [$code, new Reference($id)]);
        }
    }
}
