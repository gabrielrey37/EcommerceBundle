<?php

namespace MauticPlugin\EcommerceBundle\Model;

use Mautic\CoreBundle\Helper\Chart\ChartQuery;
use Mautic\CoreBundle\Helper\Chart\LineChart;
use Mautic\CoreBundle\Model\FormModel;
use Mautic\LeadBundle\Entity\Lead;
use MauticPlugin\EcommerceBundle\Entity\Cart;
use MauticPlugin\EcommerceBundle\Entity\Order;
use MauticPlugin\EcommerceBundle\Form\Type\CartType;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;


class OrderModel extends FormModel{

    public function saveEntity($entity, $unlock = true)
    {
        parent::saveEntity($entity, $unlock);
    }

    public function getEntity($id = null)
    {
        if (null === $id) {
            $entity = new Order();
        } else {
            $entity = parent::getEntity($id);
        }
        return $entity;
    }

    public function createForm($entity, $formFactory, $action = null, $options = [])
    {
        if (!$entity instanceof Order) {
            throw new MethodNotAllowedHttpException(['Order']);
        }

        if (!empty($action)) {
            $options['action'] = $action;
        }

        return $formFactory->create(CartType::class, $entity, $options);
    }

    public function getRepository()
    {
        return $this->em->getRepository('EcommerceBundle:Order');
    }

    public function getOrderRowRepository()
    {
        return $this->em->getRepository('EcommerceBundle:OrderRow');
    }

    public function getPermissionBase()
    {
        return 'ecommerce:orders';
    }

    public function getOrderById($id, $shopId=0){
        $q = $this->em->getConnection()->createQueryBuilder();
        $q->select('ord.id, ord.cart_id, ord.shop_id, ord.date_added, ord.date_modified')
            ->from(MAUTIC_TABLE_PREFIX.'orders', 'ord');
        $q->andWhere('ord.order_id = :id')
            ->setParameter('id', $id);
        $q->andWhere('ord.shop_id = :shopId')
            ->setParameter('shopId', $shopId);
        return $q->execute()->fetchAll();
    }

    public function getOrdersByLead (Lead $lead)
    {
        return $this->getRepository()->getEntities(
            [
                'filter' => [
                    'force' => [
                        [
                            'column' => 'ord.lead',
                            'expr'   => 'eq',
                            'value'  => $lead,
                        ],
                    ],
                ],
                'oderBy'         => 'ord.date_modified',
                'orderByDir'     => 'ASC',
            ]);
    }
}