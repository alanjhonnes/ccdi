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

use Doctrine\ORM\EntityManager;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\HttpFoundation\Response;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Validator\ErrorElement;

use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\BlockBundle\Block\BaseBlockService;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Templating\EngineInterface;

/**
 *
 * @author     Alan Jhonnes <aj@alanjhonnes.com>
 */
class PostsBlockService extends BaseBlockService
{

    /**
     * @var \CCDI\CoreBundle\Entity\PostRepository
     */
    protected $postRepository;
    
    public function __construct($name, EngineInterface $templating, EntityManager $em) {
        parent::__construct($name, $templating);
        $this->postRepository = $em->getRepository('CCDICoreBundle:Post');
    }
    
    /**
     * {@inheritdoc}
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        
        $settings = $blockContext->getSettings();
        
        $numPosts = $blockContext->getSetting('numPosts');
        
        $posts = $this->postRepository->getRecentPosts($numPosts);
        
        
        return $this->renderResponse($blockContext->getTemplate(), array(
            'posts' => $posts,
            'block'     => $blockContext->getBlock(),
            'settings'  => $settings
        ), $response);
    }

    /**
     * {@inheritdoc}
     */
    public function validateBlock(ErrorElement $errorElement, BlockInterface $block)
    {
        
    }

    /**
     * {@inheritdoc}
     */
    public function buildEditForm(FormMapper $formMapper, BlockInterface $block)
    {
        $numPosts = $block->getSetting('numPosts');

        if(!$numPosts){
            $numPosts = 5;
        }

        $formMapper->add('settings', 'sonata_type_immutable_array', array(
            'keys' => array(
                array('numPosts', 'integer', array('label' => 'Número máximo de noticias', 'data'=>$numPosts)),
            )
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Notícias';
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'numPosts'  => '10',
            'template' => 'CCDITVBundle:Block:posts.html.twig'
        ));
    }
}