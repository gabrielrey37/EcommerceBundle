<?php
namespace MauticPlugin\EcommerceBundle;

use Mautic\PluginBundle\Bundle\PluginBundleBase;
use MauticPlugin\EcommerceBundle\DependencyInjection\Compiler\OverridePageModelPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class EcommerceBundle extends PluginBundleBase
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new OverridePageModelPass());
    }
}