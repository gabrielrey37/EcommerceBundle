<?php

declare(strict_types=1);

namespace MauticPlugin\EcommerceBundle\Entity;

use Mautic\CoreBundle\Entity\CommonRepository;

class OrederRowRepository extends CommonRepository
{
    public function getEntities(array $args = [])
    {
         $q = $this
            ->createQueryBuilder('orw')
            ->select('orw');

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
            ['orw.cartId', 'ASC'],
        ];
    }
    

    public function getTableAlias()
    {
        return 'orw';
    }

    public function getEntitiesIds(Order $order)
    {
        $q = $this
            ->createQueryBuilder('orw')
            ->select('orw.id')
            ->leftJoin('orw.order', 'ord')
            ->where('orw.order='.$order->getId());

        $args['qb'] = $q;
        $query = $q->getQuery();
        return $query->getResult();
    }

}
