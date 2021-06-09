<?php

namespace MauticPlugin\EcommerceBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Mautic\ApiBundle\Serializer\Driver\ApiMetadataDriver;
use Mautic\CoreBundle\Doctrine\Mapping\ClassMetadataBuilder;
use Mautic\CoreBundle\Entity\FormEntity;
use Mautic\LeadBundle\Entity\Lead;


class Cart extends FormEntity
{

    private $id;

    private $cartId;

    private $shopId;

    private $carrierId;

    private $addressDeliveryId;

    private $addressInvoiceId;

    private $lead;

    private $gift;

    private $cartLines;

    private $productsCount = 15;

    private $type;

    public function __construct()
    {
        $this->cartLines = new ArrayCollection();
    }

    public static function loadMetadata(ORM\ClassMetadata $metadata): void
    {
        $builder = new ClassMetadataBuilder($metadata);

        $builder
            ->setTable('carts')
            ->setCustomRepositoryClass(CartRepository::class)
            ->addIndex(['cart_id'],'cartId')
            ->addUniqueConstraint(['cart_id', 'shop_id'], 'unique_cart');

        $builder->addId();

        $builder->addLead(true);

        $builder->createField('cartId', 'integer')
            ->columnName('cart_id')
            ->build();

        $builder->createField('shopId', 'integer')
            ->columnName('shop_id')
            ->build();

        $builder->createField('carrierId', 'integer')
            ->columnName('carrier_id')
            ->build();

        $builder->createOneToMany('cartLines', 'CartLine')
            ->orphanRemoval()
            ->setIndexBy('id')
            ->mappedBy('cart')
            ->cascadeAll()
            ->fetchExtraLazy()
            ->build();

        $builder->createField('addressDeliveryId', 'integer')
            ->columnName('address_delivery_id')
            ->build();

        $builder->createField('addressInvoiceId', 'integer')
            ->columnName('address_invoice_id')
            ->build();
    }

    public static function loadApiMetadata(ApiMetadataDriver $metadata)
    {
        $metadata->setGroupPrefix('cart')
            ->addListProperties(
                [
                    'referenceId',
                ]
            )
            ->addProperties(
                [
                ]
            )
            ->build();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getLead()
    {
        return $this->lead;
    }


    public function setLead(Lead $lead)
    {
        $this->lead = $lead;

        return $this;
    }

    public function getCartId()
    {
        return $this->cartId;
    }

    public function setCartId($cartId)
    {
        $this->cartId = $cartId;
    }

    public function getShopId()
    {
        return $this->shopId;
    }

    public function setShopId($shopId)
    {
        $this->shopId = $shopId;
    }


    public function clearCartLines()
    {
        $this->cartLines = new ArrayCollection();
    }

    public function getCartLines()
    {
        return $this->cartLines;
    }

    public function addCartLine(CartLine $cartLine)
    {
        $this->cartLines[] = $cartLine;
        return $this;
    }

    public function getCarrierId()
    {
        return $this->carrierId;
    }

    public function setCarrierId($carrierId)
    {
        $this->carrierId = $carrierId;
    }

    public function getAddressDeliveryId()
    {
        return $this->addressDeliveryId;
    }

    public function setAddressDeliveryId($addressDeliveryId)
    {
        $this->addressDeliveryId = $addressDeliveryId;
    }

    public function getAddressInvoiceId()
    {
        return $this->addressInvoiceId;
    }

    public function setAddressInvoiceId($addressInvoiceId)
    {
        $this->addressInvoiceId = $addressInvoiceId;
    }
/*
    public function getLead()
    {
        return $this->lead;
    }

    public function setLead($lead)
    {
        $this->lead = $lead;
    }
*/
    public function getGift()
    {
        return $this->gift;
    }

    public function setGift($gift)
    {
        $this->gift = $gift;
    }

    public function getProductsCount()
    {
        return count($this->getCartLines());
    }

    public function getTotal()
    {
        $total = 0;
        foreach ($this->getCartLines() as $cartLine)
        {
            $total = $total + (float)$cartLine->getProduct()->getPrice() * (float)$cartLine->getQuantity();
        }

        return $total;
    }

    public function getType()
    {
        return $this->type;
    }

}