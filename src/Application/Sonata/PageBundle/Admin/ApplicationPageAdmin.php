<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Sonata\PageBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;

use Sonata\PageBundle\Exception\PageNotFoundException;
use Sonata\PageBundle\Exception\InternalErrorException;
use Sonata\PageBundle\Model\PageInterface;
use Sonata\PageBundle\Model\PageManagerInterface;
use Sonata\PageBundle\Model\SiteManagerInterface;

use Sonata\Cache\CacheManagerInterface;

use Sonata\PageBundle\Admin\PageAdmin;

use Knp\Menu\ItemInterface as MenuItemInterface;

/**
 * Admin definition for the Page class
 *
 * @author Thomas Rabaix <thomas.rabaix@sonata-project.org>
 */
class ApplicationPageAdmin extends PageAdmin
{
   

    public function configureRoutes(RouteCollection $routes)
    {
        $routes->add('compose', '{id}/compose', array(
            'id' => null,
        ));
        $routes->add('compose_container_show', 'compose/container/{id}', array(
            'id' => null,
        ));

        $routes->add('tree', 'tree');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('site')
            ->add('routeName')
            ->add('pageAlias')
            ->add('type')
            ->add('enabled')
            ->add('decorate')
            ->add('name')
            ->add('slug')
            ->add('customUrl')
            ->add('edited')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('hybrid', 'text', array('template' => 'SonataPageBundle:PageAdmin:field_hybrid.html.twig'))
            ->addIdentifier('name')
            ->add('type')
//            ->add('pageAlias')
            ->add('theme')
            ->add('url')
            ->add('site')
            ->add('decorate', null, array('editable' => false))
            ->add('enabled', null, array('editable' => false))
            ->add('edited', null, array('editable' => false))
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('site')
            ->add('name')
            ->add('type', null, array('field_type' => 'sonata_page_type_choice'))
            ->add('pageAlias')
            ->add('parent')
            ->add('edited')
            ->add('hybrid', 'doctrine_orm_callback', array(
                'callback' => function($queryBuilder, $alias, $field, $data) {
                    if (in_array($data['value'], array('hybrid', 'cms'))) {
                        $queryBuilder->andWhere(sprintf('%s.routeName %s :routeName', $alias, $data['value'] == 'cms' ? '=' : '!='));
                        $queryBuilder->setParameter('routeName', PageInterface::PAGE_ROUTE_CMS_NAME);
                    }
                },
                'field_options' => array(
                    'required' => false,
                    'choices'  => array(
                        'hybrid'  => $this->trans('hybrid'),
                        'cms'     => $this->trans('cms'),
                    )
                ),
                'field_type' => 'choice'
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {

        // define group zoning
        $formMapper
             ->with($this->trans('form_page.group_main_label'), array('class' => 'col-md-12'))
        ;


        if (!$this->getSubject() || (!$this->getSubject()->isInternal() && !$this->getSubject()->isError())) {
            $formMapper
                ->with($this->trans('form_page.group_main_label'))
                    ->add('url', 'text', array('attr' => array('readonly' => 'readonly')))
                ->end()
            ;
        }

        if ($this->hasSubject() && !$this->getSubject()->getId()) {
            $formMapper
                ->with($this->trans('form_page.group_main_label'))
                    ->add('site', null, array('required' => true, 'read_only' => true))
                ->end();
        }

        $formMapper
            ->with($this->trans('form_page.group_main_label'))
                ->add('name')
                ->add('theme', 'choice', array('required' => true, 'choices' => array('theme-1' => 'Tema padrão', 'theme-2' => 'Tema 2', 'theme-3' => 'Tema 3')))
                ->add('enabled', null, array('required' => false))
                ->add('position')
            ->end();

        if ($this->hasSubject() && !$this->getSubject()->isInternal()) {
            $formMapper
                ->with($this->trans('form_page.group_main_label'))
                    ->add('type', 'sonata_page_type_choice', array('required' => true))
                ->end()
            ;
        }

        $formMapper
            ->with($this->trans('form_page.group_main_label'))
                ->add('templateCode', 'sonata_page_template', array('required' => true))
            ->end()
        ;

        if (!$this->getSubject() || ($this->getSubject() && $this->getSubject()->getParent()) || ($this->getSubject() && !$this->getSubject()->getId())) {
            $formMapper
                ->with($this->trans('form_page.group_main_label'))
                    ->add('parent', 'sonata_page_selector', array(
                        'page'          => $this->getSubject() ?: null,
                        'site'          => $this->getSubject() ? $this->getSubject()->getSite() : null,
                        'model_manager' => $this->getModelManager(),
                        'class'         => $this->getClass(),
                        'required'      => false,
                        'filter_choice' => array('hierarchy' => 'root'),
                    ), array(
                        'link_parameters' => array(
                            'siteId' => $this->getSubject() ? $this->getSubject()->getSite()->getId() : null
                        )
                    ))
                ->end()
            ;
        }

//        if (!$this->getSubject() || !$this->getSubject()->isDynamic()) {
//            $formMapper
//                ->with($this->trans('form_page.group_main_label'))
//                    ->add('pageAlias', null, array('required' => false))
//                    ->add('target', 'sonata_page_selector', array(
//                        'page'          => $this->getSubject() ?: null,
//                        'site'          => $this->getSubject() ? $this->getSubject()->getSite() : null,
//                        'model_manager' => $this->getModelManager(),
//                        'class'         => $this->getClass(),
//                        'filter_choice' => array('request_method' => 'all'),
//                        'required'      => false
//                    ), array(
//                        'link_parameters' => array(
//                            'siteId' => $this->getSubject() ? $this->getSubject()->getSite()->getId() : null
//                        )
//                    ))
//                ->end()
//            ;
//        }

        $formMapper->setHelps(array(
            'name' => $this->trans('help_page_name')
        ));
    }

    /**
     * {@inheritdoc}
     */
    protected function configureSideMenu(MenuItemInterface $menu, $action, AdminInterface $childAdmin = null)
    {
        if (!$childAdmin && !in_array($action, array('edit'))) {
            return;
        }

        $admin = $this->isChild() ? $this->getParent() : $this;


        $id = $admin->getRequest()->get('id');

        $menu->addChild(
            $this->trans('sidemenu.link_edit_page'),
            array('uri' => $admin->generateUrl('edit', array('id' => $id)))
        );

        $menu->addChild(
            $this->trans('sidemenu.link_compose_page'),
            array('uri' => $admin->generateUrl('compose', array('id' => $id)))
        );

        $menu->addChild(
            $this->trans('sidemenu.link_list_blocks'),
            array('uri' => $admin->generateUrl('sonata.page.admin.block.list', array('id' => $id)))
        );

        $menu->addChild(
            $this->trans('sidemenu.link_list_snapshots'),
            array('uri' => $admin->generateUrl('sonata.page.admin.snapshot.list', array('id' => $id)))
        );

        if (!$this->getSubject()->isHybrid() && !$this->getSubject()->isInternal()) {

            try {
                $menu->addChild(
                    $this->trans('view_page'),
                    array('uri' => $this->getRouteGenerator()->generate('page_slug', array('path' => $this->getSubject()->getUrl())))
                );
            } catch (\Exception $e) {
                // avoid crashing the admin if the route is not setup correctly
//                throw $e;
            }
        }
    }

}
