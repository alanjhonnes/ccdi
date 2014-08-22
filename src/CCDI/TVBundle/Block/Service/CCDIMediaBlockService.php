<?php
/*
 * This file is part of the Sonata project.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CCDI\TVBundle\Block\Service;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Validator\ErrorElement;

use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\BlockBundle\Block\BaseBlockService;

use Sonata\CoreBundle\Model\ManagerInterface;
use Sonata\MediaBundle\Model\MediaInterface;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Sonata\MediaBundle\Block\MediaBlockService;

/**
 * PageExtension
 *
 * @author     Thomas Rabaix <thomas.rabaix@sonata-project.org>
 */
class CCDIMediaBlockService extends MediaBlockService
{
    protected $mediaAdmin;

    protected $mediaManager;

    /**
     * @param string             $name
     * @param EngineInterface    $templating
     * @param ContainerInterface $container
     * @param ManagerInterface   $mediaManager
     */
    public function __construct($name, EngineInterface $templating, ContainerInterface $container, ManagerInterface $mediaManager)
    {
        parent::__construct($name, $templating, $container, $mediaManager);

        //$this->mediaManager = $mediaManager;
        //$this->container    = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'media'    => false,
            'context'  => false,
            'mediaId'  => null,
            'format'   => 'default_big',
            'template' => 'CCDITVBundle:Block:media.html.twig'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildEditForm(FormMapper $formMapper, BlockInterface $block)
    {
        if (!$block->getSetting('mediaId') instanceof MediaInterface) {
            $this->load($block);
        }

        $formatChoices = $this->getFormatChoices($block->getSetting('mediaId'));

        $formMapper->add('settings', 'sonata_type_immutable_array', array(
            'keys' => array(
                array($this->getMediaBuilder($formMapper), null, array()),
                //array('format', 'choice', array('required' => count($formatChoices) > 0,
                //    'choices' => $formatChoices)),
            )
        ));
    }
}
