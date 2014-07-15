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

use CCDI\CoreBundle\Entity\Post;

class LoadPostData extends AbstractFixture implements ContainerAwareInterface, OrderedFixtureInterface
{
    private $container;

    function getOrder()
    {
        return 1;
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $faker = $this->getFaker();
        
        for ($index = 0; $index < 100; $index++) {
            $post = new Post();
            $post->setDatetime($faker->dateTimeThisYear);
            $post->setOfficeOnly($faker->boolean());
            if($post->getOfficeOnly()){
                $post->setTitle('Título noticia escritório ' . $index);
            }
            else {
                $post->setTitle('Título noticia generica ' . $index);
            }
            
            $post->setContent('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent dictum, neque ut imperdiet venenatis.');
            
            $manager->persist($post);
        }
            
        $manager->flush();
        
    }

    /**
     * @return \Faker\Generator
     */
    public function getFaker()
    {
        return $this->container->get('faker.generator');
    }
}
