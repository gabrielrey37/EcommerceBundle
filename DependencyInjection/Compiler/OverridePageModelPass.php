<?php

namespace MauticPlugin\EcommerceBundle\DependencyInjection\Compiler;

use MauticPlugin\EcommerceBundle\Model\OverridePageModel;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;


class OverridePageModelPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $definitionDecorator = $container->getDefinition('mautic.page.model.page');
        $definitionDecorator->setFactory(null);
        $definitionDecorator->setClass(OverridePageModel::class);
    }
}
