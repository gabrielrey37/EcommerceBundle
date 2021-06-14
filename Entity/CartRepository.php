<?php

declare(strict_types=1);

namespace MauticPlugin\EcommerceBundle\Entity;

use Mautic\CoreBundle\Entity\CommonRepository;

class CartRepository extends CommonRepository
{
    public function getEntities(array $args = [])
    {
        /*
        $q = $this
            ->createQueryBuilder('ca')
            ->select('ca', 'ord')
            ->Join(Order::class,'ord');*/

        $q = $this
            ->createQueryBuilder('ca')
            ->select('ca');
        $args['qb'] = $q;

        return parent::getEntities($args);
    }

    public function getEntitiesIds($shopId)
    {
        $q = $this
            ->createQueryBuilder('ca')
            ->select('ca.id, ca.shopId')
            ->where('ca.shopId='.(int)$shopId);

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

/*
    protected function addCatchAllWhereClause($q, $filter)
    {
        return $this->addStandardCatchAllWhereClause($q, $filter, [
            'p.name',
            'p.reference',
        ]);
    }


    protected function addSearchCommandWhereClause($q, $filter)
    {
        list($expr, $parameters) = $this->addStandardSearchCommandWhereClause($q, $filter);
        if ($expr) {
            return [$expr, $parameters];
        }
        $command         = $field         = $filter->command;
        $unique          = $this->generateRandomParameterName();
        $returnParameter = false; //returning a parameter that is not used will lead to a Doctrine error

        switch ($command) {
            case $this->translator->trans('mautic.ecommerce.product.productId'):
                $langUnique      = $this->generateRandomParameterName();
                $langValue       = $filter->string.'_%';
                $forceParameters = [
                    $langUnique => $langValue,
                    $unique     => $filter->string,
                ];
                $expr = $q->expr()->orX(
                    $q->expr()->eq('p.productId', ":$unique"),
                    $q->expr()->eq('p.productId', ":$langUnique")
                );
                $returnParameter = true;
                break;
            case $this->translator->trans('mautic.ecommerce.product.shopId'):
                $langUnique      = $this->generateRandomParameterName();
                $langValue       = $filter->string.'_%';
                $forceParameters = [
                    $langUnique => $langValue,
                    $unique     => $filter->string,
                ];
                $expr = $q->expr()->orX(
                    $q->expr()->eq('p.shopId', ":$unique"),
                    $q->expr()->eq('p.shopId', ":$langUnique")
                );
                $returnParameter = true;
                break;
            case $this->translator->trans('mautic.ecommerce.product.reference'):
                $expr = $q->expr()->like('p.reference',$q->expr()->literal($filter->string . '%'));
                $returnParameter = false;
                break;

            case $this->translator->trans('mautic.ecommerce.product.searchcommand.showcombinations'):
            case $this->translator->trans('mautic.ecommerce.product.searchcommand.showcombinations', [], null, 'en_US'):
                $this->groupByProductId($q);
                break;

            case $this->translator->trans('mautic.ecommerce.product.discounts'):
            case $this->translator->trans('mautic.ecommerce.product.discounts', [], null, 'en_US'):
                $expr = $q->expr()->neq('p.price','p.discount');
                $returnParameter = false;
                break;
        }

        if ($expr && $filter->not) {
            $expr = $q->expr()->not($expr);
        }

        if (!empty($forceParameters)) {
            $parameters = $forceParameters;
        } elseif (!$returnParameter) {
            $parameters = [];
        } else {
            $string     = ($filter->strict) ? $filter->string : "%{$filter->string}%";
            $parameters = ["$unique" => $string];
        }

        return [$expr, $parameters];
    }


    public function getSearchCommands()
    {
        $commands = [
            'mautic.core.searchcommand.ispublished',
            'mautic.core.searchcommand.isunpublished',
            'mautic.core.searchcommand.isuncategorized',
            'mautic.core.searchcommand.ismine',
            'mautic.core.searchcommand.category',
            'mautic.ecommerce.product.productId',
            'mautic.ecommerce.product.shopId',
            'mautic.ecommerce.product.discounts',
            'mautic.ecommerce.product.reference',
            'mautic.ecommerce.product.searchcommand.showcombinations',
        ];

        return array_merge($commands, parent::getSearchCommands());
    }
*/

    protected function getDefaultOrder()
    {
        return [
            ['ca.id', 'ASC'],
        ];
    }
    

    public function getTableAlias()
    {
        return 'ca';
    }

}
