<?php

namespace MauticPlugin\EcommerceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Mautic\ApiBundle\Serializer\Driver\ApiMetadataDriver;
use Mautic\CoreBundle\Doctrine\Mapping\ClassMetadataBuilder;

class OrderRow
{
    private $id;

    private $order;

    private $product;

    private $productQuantity;

    private $productPrice;

    private $idCustomization;

    private $unitPriceTaxIncl;

    private $unitPriceTaxExcl;

    private $dateAdd;

    private $dateUpd;

    public static function loadMetadata(ORM\ClassMetadata $metadata): void
    {
        $builder = new ClassMetadataBuilder($metadata);

        $builder->addId();

        $builder
            ->setTable('order_rows')
            ->setCustomRepositoryClass(OrederRowRepository::class)
            ->addIndex(['order_id'], 'order_id_index');

        $builder->createManyToOne('order', 'Order')
            ->inversedBy('orderRows')
            ->addJoinColumn('order_id', 'id', true, false)
            ->build();

        $builder->createManyToOne('product', 'Product')
            ->addJoinColumn('product_id', 'id', true, false)
            ->build();

        $builder->createField('productQuantity', 'float')
            ->columnName('product_quantity')
            ->build();


        $builder->createField('productPrice', 'float')
            ->columnName('product_price')
            ->build();

        $builder->createField('unitPriceTaxIncl', 'float')
            ->columnName('unit_price_tax_incl')
            ->build();

        $builder->createField('unitPriceTaxExcl', 'float')
            ->columnName('unit_price_tax_excl')
            ->build();

        $builder->createField('dateAdd', 'datetime')
            ->columnName('date_add')
            ->build();

        $builder->createField('dateUpd', 'datetime')
            ->columnName('date_upd')
            ->build();
    }

    public static function loadApiMetadata(ApiMetadataDriver $metadata)
    {
        $metadata->setGroupPrefix('stat')
            ->addProperties(
                [
                    'orderId',
                ]
            )
            ->build();
    }
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }
    public function getProductId()
    {
        return $this->product;
    }

    public function setProduct(Product $product)
    {
        $this->product = $product;
    }

    public function getProductQuantity()
    {
        return $this->productQuantity;
    }

    public function setProductQuantity($productQuantity)
    {
        $this->productQuantity = $productQuantity;
    }

    public function getProductPrice()
    {
        return $this->productPrice;
    }

    public function setProductPrice($productPrice)
    {
        $this->productPrice = $productPrice;
    }
    public function getIdCustomization()
    {
        return $this->idCustomization;
    }

    public function setIdCustomization($idCustomization)
    {
        $this->idCustomization = $idCustomization;
    }
    public function getUnitPriceTaxIncl()
    {
        return $this->unitPriceTaxIncl;
    }

    public function setUnitPriceTaxIncl($unitPriceTaxIncl)
    {
        $this->unitPriceTaxIncl = $unitPriceTaxIncl;
    }
    public function getUnitPriceTaxExcl()
    {
        return $this->unitPriceTaxExcl;
    }

    public function setUnitPriceTaxExcl($unitPriceTaxExcl)
    {
        $this->unitPriceTaxExcl = $unitPriceTaxExcl;
    }

    public function getDateAdd()
    {
        return $this->dateAdd;
    }

    public function setDateAdd($dateAdd)
    {
        $this->dateAdd = $dateAdd;
    }

    public function getDateUpd()
    {
        return $this->dateUpd;
    }

    public function setDateUpd($dateUpd)
    {
        $this->dateUpd = $dateUpd;
    }

    public function getOrder()
    {
        return $this->order;
    }

    public function setOrder(Order $order)
    {
        $this->order = $order;
    }

}