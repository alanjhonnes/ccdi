<?php
/**
 * Created by PhpStorm.
 * User: Alan Jhonnes
 * Date: 7/30/14
 * Time: 11:00 AM
 */

namespace Application\Sonata\PageBundle\Entity;


use Doctrine\ORM\EntityRepository;

class PageRepository extends EntityRepository {

    public function findAllPublicPages(){
        return $this->getEntityManager()->createQueryBuilder()
            ->from('ApplicationSonataPageBundle:Page', 'p')
            ->select('p')
            ->andWhere('p.enabled = :enabled')
            ->andWhere('p.url != :url')
            ->andWhere('p.url != :url2' )
            ->setParameter('url', '/')
            ->setParameter('url2', '')
            ->setParameter('enabled', true)
            ->getQuery()->execute();
        ;
    }

} 