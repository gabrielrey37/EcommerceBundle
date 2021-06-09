<?php

declare(strict_types=1);

namespace MauticPlugin\EcommerceBundle\Entity;

use Mautic\CoreBundle\Entity\CommonRepository;

class CartLineRepository extends CommonRepository
{
    public function getEntities(array $args = [])
    {
         $q = $this
            ->createQueryBuilder('cl')
            ->select('cl');

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
            ['cl.cartId', 'ASC'],
        ];
    }
    

    public function getTableAlias()
    {
        return 'cl';
    }

    public function getEntitiesIds(Cart $cart)
    {
        $q = $this
            ->createQueryBuilder('cl')
            ->select('cl.id')
            ->leftJoin('cl.cart', 'ca')
            ->where('cl.cart='.$cart->getId());

        $args['qb'] = $q;
        $query = $q->getQuery();
        return $query->getResult();
    }

}
