<?php

/*
 * @copyright   2014 Mautic Contributors. All rights reserved
 * @author      Mautic
 *
 * @link        http://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
if ('index' == $tmpl) {
    $view->extend('EcommerceBundle:Order:index.html.php');
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
                        'sessionVar' => 'order',
                        'text'       => 'mautic.ecommerce.lead',
                        'default'    => false,
                    ]
                );

                echo $view->render(
                    'MauticCoreBundle:Helper:tableheader.html.php',
                    [
                        'sessionVar' => 'order',
                        'text'       => 'mautic.ecommerce.externalId',
                        'class'      => 'visible-md visible-lg',
                        'orderBy'    => 'ord.orderId',
                        'default'    => false,
                    ]
                );

                echo $view->render(
                    'MauticCoreBundle:Helper:tableheader.html.php',
                    [
                        'sessionVar' => 'order',
                        'orderBy'    => 'ord.shopId',
                        'text'       => 'mautic.ecommerce.shopId',
                        'class'      => 'visible-md visible-lg',
                        'default'    => true,
                    ]
                );

                echo $view->render(
                    'MauticCoreBundle:Helper:tableheader.html.php',
                    [
                        'sessionVar' => 'order',
                        'orderBy'    => 'ord.reference',
                        'text'       => 'mautic.ecommerce.reference',
                        'default'    => true,
                    ]
                );


                echo $view->render(
                    'MauticCoreBundle:Helper:tableheader.html.php',
                    [
                        'sessionVar' => 'order',
                        'orderBy'    => 'ord.lead',
                        'text'       => 'mautic.ecommerce.total',
                        'class'      => 'col-product-name',
                        'default'    => true,
                    ]
                );

                echo $view->render(
                    'MauticCoreBundle:Helper:tableheader.html.php',
                    [
                        'sessionVar' => 'order',
                        'orderBy'    => 'ca.dateAdded',
                        'text'       => 'mautic.ecommerce.date',
                    ]
                );

                echo $view->render(
                    'MauticCoreBundle:Helper:tableheader.html.php',
                    [
                        'sessionVar' => 'order',
                        'orderBy'    => 'ord.id',
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
                        <?php echo $item->getOrderId(); ?>
                    </td>
                    <td class="visible-md visible-lg">
                        <span><?php echo $item->getShopId(); ?></span>
                    </td>
                    <td class="">
                        <a href="<?php echo $view['router']->path(
                            'mautic_order_action',
                            ['objectAction' => 'view', 'objectId' => $item->getId()]
                        ); ?>" data-toggle="ajax"
                        >
                        <span><?php echo $item->getReference(); ?></span>
                        </a>
                    </td>
                    <td class="text-right"><?php echo '$ ' .number_format($item->getTotalProducts(), 2); //TODO CURRENCY ?></td>
                    <td class=""><?php
                        echo $item->getDateAdded()->format('Y-m-d H:i:s');;
                        ?></td>
                    <td class="">
                        <a href="<?php echo $view['router']->path(
                            'mautic_order_action',
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
                'menuLinkId' => 'mautic_order_index',
                'baseUrl'    => $view['router']->path('mautic_order_index'),
                'sessionVar' => 'order',
            ]
        ); ?>
    </div>
<?php else: ?>
    <?php echo $view->render('MauticCoreBundle:Helper:noresults.html.php', ['tip' => 'mautic.ecommerce.noresults.tip']); ?>
<?php endif; ?>

<?php echo $view->render(
    'MauticCoreBundle:Helper:modal.html.php',
    [
        'id'     => 'OrderPreviewModal',
        'header' => false,
    ]
);
