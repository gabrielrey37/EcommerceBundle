<?php

namespace MauticPlugin\EcommerceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Mautic\ApiBundle\Serializer\Driver\ApiMetadataDriver;
use Mautic\CoreBundle\Doctrine\Mapping\ClassMetadataBuilder;

class CartLine
{
    private $id;

    private $cart;

    private $product;

    private $quantity;

    private $dateAdd;

    private $dateUpd;

    public static function loadMetadata(ORM\ClassMetadata $metadata): void
    {
        $builder = new ClassMetadataBuilder($metadata);

        $builder->addId();

        $builder
            ->setTable('cart_lines')
            ->setCustomRepositoryClass(CartLineRepository::class)
            ->addIndex(['cart_id'], 'cart_id_index')
            ->addUniqueConstraint(['cart_id','product_id'], 'unique_cart_line');

        $builder->createManyToOne('cart', 'Cart')
            ->inversedBy('cartLines')
            ->addJoinColumn('cart_id', 'id', true, false)
            ->build();


        $builder->createManyToOne('product', 'Product')
            ->addJoinColumn('product_id', 'id', true, false)
            ->build();


        $builder->createField('quantity', 'integer')
            ->columnName('quantity')
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
                    'cartId',
                ]
            )
            ->build();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getCart()
    {
        return $this->cart;
    }

    public function setCart(Cart $cart)
    {
        $this->cart = $cart;
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function setProduct(Product $product)
    {
        $this->product = $product;
    }


    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
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

}