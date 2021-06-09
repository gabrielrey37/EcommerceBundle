<?php

namespace MauticPlugin\EcommerceBundle\Entity;

use Mautic\PageBundle\Entity\Hit;
use Doctrine\ORM\Mapping as ORM;
use Mautic\CoreBundle\Doctrine\Mapping\ClassMetadataBuilder;

class OverrideHit extends Hit
{
    private $productId;
    
    private $shopId;

    private $productAttributeId;

    public static function loadMetadata(ORM\ClassMetadata $metadata)
    {
        $builder = new ClassMetadataBuilder($metadata);

        $builder->setTable('page_hits')
            ->addIndex(['tracking_id'], 'page_hit_tracking_search')
            ->addIndex(['code'], 'page_hit_code_search')
            ->addIndex(['source', 'source_id'], 'page_hit_source_search')
            ->addIndex(['date_hit', 'date_left'], 'date_hit_left_index');

        $builder->createField('productId', 'integer')
            ->columnName('product_id')
            ->nullable()
            ->build();

        $builder->createField('productAttributeId', 'integer')
            ->columnName('product_attribute_id')
            ->nullable()
            ->build();

        $builder->createField('shopId', 'integer')
            ->columnName('shop_id')
            ->nullable()
            ->build();
    }
    
    
    public function setProductId($productId)
    {
        $this->productId = $productId;

        return $this;
    }

    public function getProductId()
    {
        return $this->productId;
    }
    
    public function setShopId($shopId)
    {
        $this->shopId = $shopId;

        return $this;
    }

    public function getShopId()
    {
        return $this->shopId;
    }

    public function setProductAttributeId($productAttributeId)
    {
        $this->productAttributeId = $productAttributeId;

        return $this;
    }

    public function getProductAttributeId()
    {
        return $this->productAttributeId;
    }
}
