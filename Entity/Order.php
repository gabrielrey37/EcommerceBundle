<?php

namespace MauticPlugin\EcommerceBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Mautic\ApiBundle\Serializer\Driver\ApiMetadataDriver;
use Mautic\CoreBundle\Doctrine\Mapping\ClassMetadataBuilder;
use Mautic\CoreBundle\Entity\FormEntity;
use Mautic\LeadBundle\Entity\Lead;


class Order extends FormEntity
{

    private $id;

    private $orderId;

    private $currentState;

    private $payment;

    private $totalDiscounts;

    private $totalDiscountsTaxIncl;

    private $totalDiscountsTaxExcl;

    private $totalPaid;

    private $totalPaidTaxIncl;

    private $totalPaidTaxExcl;

    private $totalPaidReal;

    private $totalProducts;

    private $totalProductsWt;

    private $totalShipping;

    private $totalShippingTaxIncl;

    private $totalShippingTaxExcl;

    private $reference;

    private $cartId;

    private $shopId;

    private $carrierId;

    private $addressDeliveryId;

    private $addressInvoiceId;

    private $lead;

    private $gift;

    private $orderRows;

    private $productsCount = 0;

    private $type;

    public function __construct()
    {
        $this->orderRows = new ArrayCollection();
    }

    public static function loadMetadata(ORM\ClassMetadata $metadata): void
    {
        $builder = new ClassMetadataBuilder($metadata);

        $builder
            ->setTable('orders')
            ->setCustomRepositoryClass(OrderRepository::class)
            ->addIndex(['order_id'],'orderId')
            ->addUniqueConstraint(['order_id', 'shop_id'], 'unique_order');

        $builder->addId();

        $builder->addLead(true);

        $builder->createField('orderId', 'integer')
            ->columnName('order_id')
            ->build();

        $builder->createOneToMany('orderRows', 'OrderRow')
            ->orphanRemoval()
            ->setIndexBy('id')
            ->mappedBy('order')
            ->cascadeAll()
            ->fetchExtraLazy()
            ->build();

        $builder->createField('currentState', 'integer')
            ->columnName('current_state')
            ->build();

        $builder->createField('payment', 'string')
            ->columnName('payment')
            ->build();

        $builder->createField('totalDiscounts', 'float')
            ->columnName('total_discounts')
            ->build();

        $builder->createField('totalDiscountsTaxIncl', 'float')
            ->columnName('total_discounts_tax_incl')
            ->build();

        $builder->createField('totalDiscountsTaxExcl', 'float')
            ->columnName('total_discounts_tax_excl')
            ->build();

        $builder->createField('totalPaid', 'float')
            ->columnName('total_paid')
            ->build();

        $builder->createField('totalPaidTaxIncl', 'float')
            ->columnName('total_paid_tax_incl')
            ->build();

        $builder->createField('totalPaidTaxExcl', 'float')
            ->columnName('total_paid_tax_excl')
            ->build();

        $builder->createField('totalPaidReal', 'float')
            ->columnName('total_paid_real')
            ->build();

        $builder->createField('totalProducts', 'float')
            ->columnName('total_products')
            ->build();

        $builder->createField('totalProductsWt', 'float')
            ->columnName('total_products_wt')
            ->build();

        $builder->createField('totalShipping', 'float')
            ->columnName('total_shipping')
            ->build();

        $builder->createField('totalShippingTaxIncl', 'float')
            ->columnName('total_shipping_tax_incl')
            ->build();

        $builder->createField('totalShippingTaxExcl', 'float')
            ->columnName('total_shipping_tax_excl')
            ->build();

        $builder->createField('reference', 'string')
            ->columnName('reference')
            ->build();

        $builder->createManyToOne('cartId', Cart::class)
            ->addJoinColumn('cart_id', 'id', true, false)
            ->build();

        $builder->createField('shopId', 'integer')
            ->columnName('shop_id')
            ->build();

        $builder->createField('carrierId', 'integer')
            ->columnName('carrier_id')
            ->build();

        $builder->createField('addressDeliveryId', 'integer')
            ->columnName('address_delivery_id')
            ->build();

        $builder->createField('addressInvoiceId', 'integer')
            ->columnName('address_invoice_id')
            ->build();

        $builder->createField('gift', 'boolean')
            ->columnName('gift')
            ->build();
    }

    public static function loadApiMetadata(ApiMetadataDriver $metadata)
    {
        $metadata->setGroupPrefix('order')
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

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getOrderId()
    {
        return $this->orderId;
    }

    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;
    }

    public function getCurrentState()
    {
        return $this->currentState;
    }

    public function setCurrentState($currentState)
    {
        $this->currentState = $currentState;
    }

    public function getPayment()
    {
        return $this->payment;
    }

    public function setPayment($payment)
    {
        $this->payment = $payment;
    }

    public function getTotalDiscounts()
    {
        return $this->totalDiscounts;
    }

    public function setTotalDiscounts($totalDiscounts)
    {
        $this->totalDiscounts = $totalDiscounts;
    }

    public function getTotalDiscountsTaxIncl()
    {
        return $this->totalDiscountsTaxIncl;
    }

    public function setTotalDiscountsTaxIncl($totalDiscountsTaxIncl)
    {
        $this->totalDiscountsTaxIncl = $totalDiscountsTaxIncl;
    }

    public function getTotalDiscountsTaxExcl()
    {
        return $this->totalDiscountsTaxExcl;
    }

    public function setTotalDiscountsTaxExcl($totalDiscountsTaxExcl)
    {
        $this->totalDiscountsTaxExcl = $totalDiscountsTaxExcl;
    }

    public function getTotalPaid()
    {
        return $this->totalPaid;
    }

    public function setTotalPaid($totalPaid)
    {
        $this->totalPaid = $totalPaid;
    }

    public function getTotalPaidTaxIncl()
    {
        return $this->totalPaidTaxIncl;
    }

    public function setTotalPaidTaxIncl($totalPaidTaxIncl)
    {
        $this->totalPaidTaxIncl = $totalPaidTaxIncl;
    }

    public function getTotalPaidTaxExcl()
    {
        return $this->totalPaidTaxExcl;
    }

    public function setTotalPaidTaxExcl($totalPaidTaxExcl)
    {
        $this->totalPaidTaxExcl = $totalPaidTaxExcl;
    }

    public function getTotalPaidReal()
    {
        return $this->totalPaidReal;
    }

    public function setTotalPaidReal($totalPaidReal)
    {
        $this->totalPaidReal = $totalPaidReal;
    }

    public function getTotalProducts()
    {
        return $this->totalProducts;
    }

    public function setTotalProducts($totalProducts)
    {
        $this->totalProducts = $totalProducts;
    }

    public function getTotalProductsWt()
    {
        return $this->totalProductsWt;
    }

    public function setTotalProductsWt($totalProductsWt)
    {
        $this->totalProductsWt = $totalProductsWt;
    }

    public function getTotalShipping()
    {
        return $this->totalShipping;
    }

    public function setTotalShipping($totalShipping)
    {
        $this->totalShipping = $totalShipping;
    }

    public function getTotalShippingTaxIncl()
    {
        return $this->totalShippingTaxIncl;
    }

    public function setTotalShippingTaxIncl($totalShippingTaxIncl)
    {
        $this->totalShippingTaxIncl = $totalShippingTaxIncl;
    }

    public function getTotalShippingTaxExcl()
    {
        return $this->totalShippingTaxExcl;
    }

    public function setTotalShippingTaxExcl($totalShippingTaxExcl)
    {
        $this->totalShippingTaxExcl = $totalShippingTaxExcl;
    }

    public function getReference()
    {
        return $this->reference;
    }

    public function setReference($reference)
    {
        $this->reference = $reference;
    }

    public function getCartId()
    {
        return $this->cartId;
    }

    public function setCartId(Cart $cartId)
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

    public function getLead()
    {
        return $this->lead;
    }

    public function setLead($lead)
    {
        $this->lead = $lead;
    }

    public function getGift()
    {
        return $this->gift;
    }

    public function setGift($gift)
    {
        $this->gift = $gift;
    }

    public function getOrderRows()
    {
        return $this->orderRows;
    }

    public function addOrderRow(OrderRow $orderRow)
    {
        $this->orderRows[] = $orderRow;
        return $this;
    }

    public function setOrderRows($orderRows)
    {
        $this->orderRows = $orderRows;
    }

    public function getProductsCount()
    {
        return $this->productsCount;
    }

    public function setProductsCount($productsCount)
    {
        $this->productsCount = $productsCount;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

}