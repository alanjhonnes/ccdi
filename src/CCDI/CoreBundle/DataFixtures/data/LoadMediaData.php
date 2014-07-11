<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\Bundle\DemoBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Finder\Finder;
use TADSNexcon\Webcar\CoreBundle\Entity\Media;


class LoadMediaData extends AbstractFixture implements ContainerAwareInterface, OrderedFixtureInterface
{
    private $container;

    function getOrder()
    {
        return 0;
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $manager = $this->getMediaManager();
        $brands = Finder::create()->name('*')->in(__DIR__.'/../data/brand');
        foreach ($brands as $file) {
            $media = $manager->create();
            $media->setBinaryContent($file);
            $media->setEnabled(true);
            $filename = strtolower(substr($file->getFileName(), 0, -4));
            $media->setName($filename);
            $this->addReference($filename . '-logo', $media);
            $manager->save($media, 'default', 'sonata.media.provider.image');
        }
        
        $vehicles = Finder::create()->name('*')->in(__DIR__.'/../data/vehicle');
        foreach ($vehicles as $file) {
            $media = $manager->create();
            $media->setBinaryContent($file);
            $media->setEnabled(true);
            $filename = substr($file->getFileName(), 0, -4);
            $media->setName($filename);
            $this->addReference($filename . '-vehicle-image', $media);
            $manager->save($media, 'default', 'sonata.media.provider.image');
        }
        
        $models = Finder::create()->name('*')->in(__DIR__.'/../data/model');
        foreach ($models as $file) {
            $media = $manager->create();
            $media->setBinaryContent($file);
            $media->setEnabled(true);
            $filename = substr($file->getFileName(), 0, -4);
            $media->setName($filename);
            $this->addReference($filename . '-model-image', $media);
            $manager->save($media, 'default', 'sonata.media.provider.image');
        }
        
        //$manager->flush();
    }
    
    /**
     * @return \Sonata\MediaBundle\Model\MediaManagerInterface
     */
    public function getMediaManager()
    {
        return $this->container->get('sonata.media.manager.media');
    }
}
