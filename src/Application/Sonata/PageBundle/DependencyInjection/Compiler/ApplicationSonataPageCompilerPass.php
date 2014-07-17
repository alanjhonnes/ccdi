<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Sonata\PageBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ApplicationSonataPageCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $definition = $container->getDefinition('sonata.page.admin.page');
        $definition->setClass('Application\Sonata\PageBundle\Admin\ApplicationPageAdmin');
        
        $definition = $container->getDefinition('sonata.page.admin.site');
        $definition->setClass('Application\Sonata\PageBundle\Admin\ApplicationSiteAdmin');
    }
}