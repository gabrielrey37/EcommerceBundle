<?php

namespace MauticPlugin\EcommerceBundle\Model;

use Mautic\CoreBundle\Model\FormModel;
use MauticPlugin\EcommerceBundle\Entity\ProductCategory;

class ProductCategoryModel extends FormModel{

    public function saveEntity($entity, $unlock = true)
    {
        parent::saveEntity($entity, $unlock);
    }

    public function getEntity($id = null)
    {
        if (null === $id) {
            $entity = new ProductCategory();
        } else {
            $entity = parent::getEntity($id);
        }
        return $entity;
    }


    public function getRepository()
    {
        return $this->em->getRepository('EcommerceBundle:ProductCategory');
    }


    public function getPermissionBase()
    {
        return 'ecommerce:productcategory';
    }

    public function getCategoryById($id, $shopId=0,  $language = 'en'){
        $q = $this->em->getConnection()->createQueryBuilder();
        $q->select('pc.id, pc.name as name, pc.category_id, pc.shop_id, pc.lang')
            ->from(MAUTIC_TABLE_PREFIX.'product_categories', 'pc');
        $q->andWhere('pc.category_id = :id')
            ->setParameter('id', $id);
        $q->andWhere('pc.shop_id = :shopId')
            ->setParameter('shopId', $shopId);
        $q->andWhere('pc.lang = :language')
            ->setParameter('language', $language);
        return $q->execute()->fetchAll();
    }

}