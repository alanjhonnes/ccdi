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

use CCDI\CoreBundle\Entity\Employee;
use CCDI\CoreBundle\Entity\EmployeeRepository;
use Doctrine\ORM\EntityManager;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Validator\ErrorElement;

use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\BlockBundle\Block\BaseBlockService;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 *
 * @author     Alan Jhonnes <aj@alanjhonnes.com>
 */
class AnniversaryBlockService extends BaseBlockService
{

    /**
     * @var EmployeeRepository
     */
    protected $employeeRepository;

    public function __construct($name, EngineInterface $templating, EntityManager $em)
    {
        parent::__construct($name, $templating);
        $this->employeeRepository = $em->getRepository('CCDICoreBundle:Employee');
    }


    /**
     * {@inheritdoc}
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {

        //Get all employees that have their anniversary today
        $employees = $this->employeeRepository->getByBirthday(new \DateTime());


        return $this->renderResponse($blockContext->getTemplate(), array(
            'employees' => $employees,
            'block'     => $blockContext->getBlock(),
            'settings'  => $blockContext->getSettings()
        ), $response);
    }

    /**
     * {@inheritdoc}
     */
    public function validateBlock(ErrorElement $errorElement, BlockInterface $block)
    {
        // TODO: Implement validateBlock() method.
    }

    /**
     * {@inheritdoc}
     */
    public function buildEditForm(FormMapper $formMapper, BlockInterface $block)
    {

    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Aniversariantes';
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'template' => 'CCDITVBundle:Block:anniversary.html.twig'
        ));
    }
}
