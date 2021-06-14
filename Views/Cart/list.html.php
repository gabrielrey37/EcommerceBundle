<?php

/*
 * @copyright   2014 Mautic Contributors. All rights reserved
 * @author      Mautic
 *
 * @link        http://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

use MauticPlugin\EcommerceBundle\Model\CartModel;

if ('index' == $tmpl) {
    $view->extend('EcommerceBundle:Cart:index.html.php');

}
?>
<?php if (count($items)): ?>
    <div class="table-responsive">
        <table class="table table-hover table-striped table-bordered product-list" id="productTable">
            <thead>
            <tr>
                <?php

                echo $view->render(
                    'MauticCoreBundle:Helper:tableheader.html.php',
                    [
                        'sessionVar' => 'cart',
                        'text'       => 'mautic.ecommerce.lead',
                        'orderBy'    => 'ca.lead',
                        'default'    => false,
                    ]
                );


                echo $view->render(
                    'MauticCoreBundle:Helper:tableheader.html.php',
                    [
                        'sessionVar' => 'cart',
                        'text'       => 'mautic.ecommerce.externalId',
                        'class'      => 'visible-md visible-lg col-asset-id',
                        'default'    => false,
                    ]
                );

                echo $view->render(
                    'MauticCoreBundle:Helper:tableheader.html.php',
                    [
                        'sessionVar' => 'cart',
                        'orderBy'    => 'ca.shopId',
                        'text'       => 'mautic.ecommerce.shopId',
                        'class'      => 'visible-md visible-lg col-asset-id',
                        'default'    => true,
                    ]
                );

                echo $view->render(
                    'MauticCoreBundle:Helper:tableheader.html.php',
                    [
                        'sessionVar' => 'cart',
                        'orderBy'    => 'ca.lead',
                        'text'       => 'mautic.ecommerce.total',
                        'class'      => 'col-product-name',
                        'default'    => true,
                    ]
                );
                echo $view->render(
                    'MauticCoreBundle:Helper:tableheader.html.php',
                    [
                        'sessionVar' => 'cart',
                        'text'       => 'mautic.ecommerce.order',
                        'default'    => true,
                    ]
                );

                echo $view->render(
                    'MauticCoreBundle:Helper:tableheader.html.php',
                    [
                        'sessionVar' => 'cart',
                        'orderBy'    => 'ca.dateModified',
                        'text'       => 'mautic.ecommerce.date',
                    ]
                );

                echo $view->render(
                    'MauticCoreBundle:Helper:tableheader.html.php',
                    [
                        'sessionVar' => 'cart',
                        'orderBy'    => 'ca.id',
                        'text'       => 'mautic.core.id',
                        'class'      => 'col-asset-id',
                    ]
                );
                ?>

            </tr>
            </thead>
            <tbody>
            <?php foreach ($items as $k => $item): ?>
                <tr>
                    <td class="">
                        <?php if ($item->getLead()):?>
                        <a href="<?php echo $view['router']->path(
                            'mautic_contact_action',
                            ['objectAction' => 'view', 'objectId' => $item->getLead()->getId()]
                        ); ?>"
                        >
                        <span><?php echo $item->getLead()->getName(); ?></span>
                        </a>
                        <?php else: ?>
                        <span>anonymous</span>
                        <?php endif; ?>
                    </td>

                    <td class="visible-md visible-lg">
                            <span><?php echo $item->getCartId(); ?></span>
                    </td>
                    <td class="visible-md visible-lg">
                        <?php $reference = $item->getShopId(); ?>
                        <span><?php echo $reference; ?></span>
                    </td>
                    <td class="text-right"><?php echo '$ ' .number_format($item->getTotal(), 2); //TODO CURRENCY ?></td>
                    <td class=""><?php
                        $order =$item->getOrder();
                        if ($order){
                            ?>
                            <a href="<?php echo $view['router']->path(
                            'mautic_order_action',
                            ['objectAction' => 'view', 'objectId' => $item->getOrder()->getId()]
                        ); ?>"
                            >
                            <?php echo $item->getOrder()->getReference(); ?>
                            </a>
                            <?php
                        }
                        else{
                            echo $view['translator']->trans('mautic.ecommerce.abandonedcart');
                        }?>
                        </td>
                    <td class=""><?php
                        echo $item->getDateModified()->format('Y-m-d H:i:s');;
                        ?></td>
                    <td class="">
                        <a href="<?php echo $view['router']->path(
                            'mautic_cart_action',
                            ['objectAction' => 'view', 'objectId' => $item->getId()]
                        ); ?>" data-toggle="ajax"
                        >
                            <span><?php echo $item->getId(); ?></span>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="panel-footer">
        <?php echo $view->render(
            'MauticCoreBundle:Helper:pagination.html.php',
            [
                'totalItems' => count($items),
                'page'       => $page,
                'limit'      => $limit,
                'menuLinkId' => 'mautic_cart_index',
                'baseUrl'    => $view['router']->path('mautic_cart_index'),
                'sessionVar' => 'cart',
            ]
        ); ?>
    </div>
<?php else: ?>
    <?php echo $view->render('MauticCoreBundle:Helper:noresults.html.php', ['tip' => 'mautic.ecommerce.noresults.tip']); ?>
<?php endif; ?>

<?php echo $view->render(
    'MauticCoreBundle:Helper:modal.html.php',
    [
        'id'     => 'CartPreviewModal',
        'header' => false,
    ]
);
