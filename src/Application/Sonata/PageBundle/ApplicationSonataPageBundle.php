<?php
/**
 * This file is part of the <name> project.
 *
 * (c) <yourname> <youremail>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Sonata\PageBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Application\Sonata\PageBundle\DependencyInjection\Compiler\ApplicationSonataPageCompilerPass;


/**
 * This file has been generated by the EasyExtends bundle ( http://sonata-project.org/easy-extends )
 *
 * References :
 *   bundles : http://symfony.com/doc/current/book/bundles.html
 *
 * @author <yourname> <youremail>
 */
class ApplicationSonataPageBundle extends Bundle
{
    
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new ApplicationSonataPageCompilerPass());
    }
    
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'SonataPageBundle';
    }
}