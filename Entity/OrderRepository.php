<?php

declare(strict_types=1);

namespace MauticPlugin\EcommerceBundle\Entity;

use Mautic\CoreBundle\Entity\CommonRepository;

class OrderRepository extends CommonRepository
{
    public function getEntities(array $args = [])
    {
         $q = $this
            ->createQueryBuilder('ord')
            ->select('ord');

        $args['qb'] = $q;

        return parent::getEntities($args);
    }

    public function getEntitiesIds($shopId)
    {
        $q = $this
            ->createQueryBuilder('ord')
            ->select('ord.id, ord.shopId')
            ->where('ord.shopId='.(int)$shopId);

        $args['qb'] = $q;
        $query = $q->getQuery();
        return $query->getResult();
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
            ['ord.id', 'ASC'],
        ];
    }
    

    public function getTableAlias()
    {
        return 'ord';
    }

}
