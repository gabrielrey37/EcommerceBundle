<?php

declare(strict_types=1);

namespace MauticPlugin\EcommerceBundle\Entity;

use Mautic\CoreBundle\Entity\CommonRepository;

class ProductCategoryRepository extends CommonRepository
{
    public function getEntities(array $args = [])
    {
         $q = $this
            ->createQueryBuilder('pc')
            ->select('pc');

        $args['qb'] = $q;

        return parent::getEntities($args);
    }

    public function saveEntity($entity, $flush = true)
    {

        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush($entity);
        }
    }

    protected function getDefaultOrder()
    {
        return [
            ['pc.name', 'ASC'],
        ];
    }
    

    public function getTableAlias()
    {
        return 'pc';
    }


}
