<?php

namespace MauticPlugin\EcommerceBundle\Model;

use Mautic\CoreBundle\Helper\Chart\ChartQuery;
use Mautic\CoreBundle\Helper\Chart\LineChart;
use Mautic\CoreBundle\Model\FormModel;
use MauticPlugin\EcommerceBundle\Entity\Product;
use MauticPlugin\EcommerceBundle\Form\Type\ProductType;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\Form\FormFactory;

class ProductModel extends FormModel{

    public function saveEntity($entity, $unlock = true)
    {
        parent::saveEntity($entity, $unlock);
    }

    public function getEntity($id = null)
    {
        if (null === $id) {
            $entity = new Product();
        } else {
            $entity = parent::getEntity($id);
        }
        return $entity;
    }

    public function createForm($entity, $formFactory, $action = null, $options = [])
    {
        if (!$entity instanceof Product) {
            throw new MethodNotAllowedHttpException(['Product']);
        }

        if (!empty($action)) {
            $options['action'] = $action;
        }

        return $formFactory->create(ProductType::class, $entity, $options);
    }

    public function getRepository()
    {
        return $this->em->getRepository('EcommerceBundle:Product');
    }

    public function getPermissionBase()
    {
        return 'ecommerce:products';
    }

    public function getProductById($id, $shopId=0, $productAttributeId=0, $language = 'en'){
        $q = $this->em->getConnection()->createQueryBuilder();
        $q->select('p.id, p.name as name, p.product_id, p.shop_id, p.date_added, p.date_modified, p.lang')
            ->from(MAUTIC_TABLE_PREFIX.'products', 'p');
        $q->andWhere('p.product_id = :id')
            ->setParameter('id', $id);
        $q->andWhere('p.shop_id = :shopId')
            ->setParameter('shopId', $shopId);
        $q->andWhere('p.product_attribute_id = :productAttributeId')
            ->setParameter('productAttributeId', $productAttributeId);
        $q->andWhere('p.lang = :language')
            ->setParameter('language', $language);
        return $q->execute()->fetchAll();
    }

    public function getProductList($limit = 10, \DateTime $dateFrom = null, \DateTime $dateTo = null, $filters = [], $options = [])
    {
        $q = $this->em->getConnection()->createQueryBuilder();
        $q->select('t.id, t.name as name, t.date_added, t.date_modified')
            ->from(MAUTIC_TABLE_PREFIX.'product', 't')
            ->setMaxResults($limit);

        if (!empty($options['canViewOthers'])) {
            $q->andWhere('t.created_by = :userId')
                ->setParameter('userId', $this->userHelper->getUser()->getId());
        }

        $chartQuery = new ChartQuery($this->em->getConnection(), $dateFrom, $dateTo);
        $chartQuery->applyFilters($q, $filters);
        $chartQuery->applyDateFilters($q, 'date_added');

        return $q->execute()->fetchAll();
    }

    public function getViewsLineChartData($unit, \DateTime $dateFrom, \DateTime $dateTo, $dateFormat = null, $filter = [], $canViewOthers = true)
    {
        $chart = new LineChart($unit, $dateFrom, $dateTo, $dateFormat);
        $chart->colors = ['#00B49C', '#4E5D9D', '#FD9572', '#FDB933', '#757575', '#9C4E5C', '#694535', '#596935'];
        $query = new ChartQuery($this->em->getConnection(), $dateFrom, $dateTo);
        $q     = $query->prepareTimeDataQuery('page_hits', 'date_hit', $filter);


        if (!$canViewOthers) {
            $q->andWhere('p.created_by = :userId')
              ->setParameter('userId', $this->userHelper->getUser()->getId());
        }

        $data = $query->loadAndBuildTimeData($q);

        $chart->setDataset($this->translator->trans('mautic.ecommerce.viewscount'), $data);

        return $chart->render();
    }
}