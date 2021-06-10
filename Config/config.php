<?php

return array(

    'name'          => 'Ecommerce',
    'description'   => 'Ecommerce for Mautic',
    'version'       => '0.1.0',
    'menu' => [
        'main' => [
            'mautic.ecommerce' => [
                'id'        => 'mautic_ecommerce_root',
                'iconClass' => 'fa-shopping-cart',
                'priority'  => 65,
            ],
            'mautic.ecommerce.products' => [
                'route'    => 'mautic_product_index',
                'access'   => 'ecommerce:products:view',
                'parent'   => 'mautic.ecommerce',
                'priority' => 10,
            ],
            'mautic.ecommerce.carts' => [
                'route'    => 'mautic_cart_index',
                'access'   => 'ecommerce:carts:view',
                'parent'   => 'mautic.ecommerce',
                'priority' => 10,
            ],
            'mautic.ecommerce.orders' => [
                'route'    => 'mautic_order_index',
                'access'   => 'ecommerce:orders:view',
                'parent'   => 'mautic.ecommerce',
                'priority' => 10,
            ],
        ],
    ],
    'routes' => [
        'main' => [
            'mautic_product_index' => [
                'path'       => '/products/{page}',
                'controller' => 'EcommerceBundle:Product:index',
            ],
            'mautic_product_action' => [
                'path'       => '/products/{objectAction}/{objectId}',
                'controller' => 'EcommerceBundle:Product:execute',
            ],
            'mautic_cart_index' => [
                'path'       => '/carts/{page}',
                'controller' => 'EcommerceBundle:Cart:index',
            ],
            'mautic_cart_action' => [
                'path'       => '/carts/{objectAction}/{objectId}',
                'controller' => 'EcommerceBundle:Cart:execute',
            ],
            'mautic_order_index' => [
                'path'       => '/orders/{page}',
                'controller' => 'EcommerceBundle:Order:index',
            ],
            'mautic_order_action' => [
                'path'       => '/orders/{objectAction}/{objectId}',
                'controller' => 'EcommerceBundle:Order:execute',
            ],
        ],
        'api' => [
            'mautic_api_productstandard' => [
                'standard_entity' => true,
                'name'            => 'product',
                'path'            => '/product',
                'controller'      => 'EcommerceBundle:Api\ProductApi',
            ],
        ],
    ],
    'services' => [
        'models' => [
            'mautic.product.model.product' => [
                'class' => \MauticPlugin\EcommerceBundle\Model\ProductModel::class
            ],
            'mautic.cart.model.cart' => [
                'class' => \MauticPlugin\EcommerceBundle\Model\CartModel::class
            ],
            'mautic.order.model.order' => [
                'class' => \MauticPlugin\EcommerceBundle\Model\OrderModel::class
            ],
            'mautic.productcategory.model.productcategory' => [
                'class' => \MauticPlugin\EcommerceBundle\Model\ProductCategoryModel::class
            ],
        ],
        'forms' => [
            'mautic.form.type.product' => [
                'class'     => \MauticPlugin\EcommerceBundle\Form\Type\ProductType::class,
                'arguments' => 'mautic.security',
            ],
            'mautic.form.type.cart' => [
                'class'     => \MauticPlugin\EcommerceBundle\Form\Type\CartType::class,
                'arguments' => 'mautic.security',
            ],
            'mautic.form.type.cartline' => [
                'class'     => \MauticPlugin\EcommerceBundle\Form\Type\CartLineType::class,
                'arguments' => 'mautic.security',
            ],
        ],
        'other' => [
                    'mautic.ecommerce.doctrineeventssubscriber.subscriber' => [
                        'class' => \MauticPlugin\EcommerceBundle\EventListener\DoctrineEventsSubscriber::class,
                        'tag'       => 'doctrine.event_subscriber',
                    ],
        ],
    ],
);
