<?php

namespace MauticPlugin\EcommerceBundle\Model;

use Mautic\CoreBundle\Helper\Chart\ChartQuery;
use Mautic\CoreBundle\Helper\Chart\LineChart;
use Mautic\CoreBundle\Model\FormModel;
use MauticPlugin\EcommerceBundle\Entity\Cart;
use MauticPlugin\EcommerceBundle\Form\Type\CartType;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;


class CartModel extends FormModel{

    public function saveEntity($entity, $unlock = true)
    {
        parent::saveEntity($entity, $unlock);
    }

    public function getEntity($id = null)
    {
        if (null === $id) {
            $entity = new Cart();
        } else {
            $entity = parent::getEntity($id);
        }
        return $entity;
    }

    public function createForm($entity, $formFactory, $action = null, $options = [])
    {
        if (!$entity instanceof Cart) {
            throw new MethodNotAllowedHttpException(['Cart']);
        }

        if (!empty($action)) {
            $options['action'] = $action;
        }

        return $formFactory->create(CartType::class, $entity, $options);
    }

    public function getRepository()
    {
        return $this->em->getRepository('EcommerceBundle:Cart');
    }

    public function getCartLineRepository()
    {
        return $this->em->getRepository('EcommerceBundle:CartLine');
    }

    public function getPermissionBase()
    {
        return 'ecommerce:carts';
    }

    public function getCartById($id, $shopId=0){
        $q = $this->em->getConnection()->createQueryBuilder();
        $q->select('ca.id, ca.cart_id, ca.shop_id, ca.date_added, ca.date_modified')
            ->from(MAUTIC_TABLE_PREFIX.'carts', 'ca');
        $q->andWhere('ca.cart_id = :id')
            ->setParameter('id', $id);
        $q->andWhere('ca.shop_id = :shopId')
            ->setParameter('shopId', $shopId);
        return $q->execute()->fetchAll();
    }


    public function getViewsLineChartData($unit, \DateTime $dateFrom, \DateTime $dateTo, $dateFormat = null, $filter = [], $canViewOthers = true)
    {
        $chart = new LineChart($unit, $dateFrom, $dateTo, $dateFormat);
        $chart->colors = ['#00B49C', '#4E5D9D', '#FD9572', '#FDB933', '#757575', '#9C4E5C', '#694535', '#596935'];
        $query = new ChartQuery($this->em->getConnection(), $dateFrom, $dateTo);
        $q     = $query->prepareTimeDataQuery('page_hits', 'date_hit', $filter);


        if (!$canViewOthers) {
            $q->andWhere('ca.created_by = :userId')
              ->setParameter('userId', $this->userHelper->getUser()->getId());
        }

        $data = $query->loadAndBuildTimeData($q);

        $chart->setDataset($this->translator->trans('mautic.ecommerce.viewscount'), $data);

        return $chart->render();
    }

    public function abandonedCart(){
        $orderRepository = $this->em->getRepository('EcommerceBundle:Order');
        $order = $orderRepository->findOneBy([
            'cart' => $this,
        ]);
        if ($order){
            return 'comprado';
        }
        return 'Abandonado';
    }
}