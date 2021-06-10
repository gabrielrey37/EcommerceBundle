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
                        //'orderBy'    => 'ord.orderId',
                        //'class'      => 'col-product-image',
                        'default'    => false,
                    ]
                );


                echo $view->render(
                    'MauticCoreBundle:Helper:tableheader.html.php',
                    [
                        'sessionVar' => 'order',
                        'text'       => 'mautic.ecommerce.order.orderId',
                        'orderBy'    => 'ord.orderId',
                        'class'      => 'col-product-image',
                        'default'    => false,
                    ]
                );

                echo $view->render(
                    'MauticCoreBundle:Helper:tableheader.html.php',
                    [
                        'sessionVar' => 'order',
                        'orderBy'    => 'ord.shopId',
                        'text'       => 'mautic.ecommerce.shopId',
                        'class'      => 'col-product-name',
                        'default'    => true,
                    ]
                );

                echo $view->render(
                    'MauticCoreBundle:Helper:tableheader.html.php',
                    [
                        'sessionVar' => 'order',
                        'text'       => 'mautic.ecommerce.order.productsCount',
                        'class'      => 'col-product-name',
                        'default'    => false,
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
/*
                echo $view->render(
                    'MauticCoreBundle:Helper:tableheader.html.php',
                    [
                        'sessionVar' => 'product',
                        'orderBy'    => 'a.downloadCount',
                        'text'       => 'mautic.asset.asset.thead.download.count',
                        'class'      => 'visible-md visible-lg col-asset-download-count',
                    ]
                );*/

                ?>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($items as $k => $item): ?>
                <tr>

                    <td class="visible-md visible-lg">
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
                        <a href="<?php echo $view['router']->path(
                            'mautic_order_action',
                            ['objectAction' => 'view', 'objectId' => $item->getId()]
                        ); ?>"
                        >
                            <span><?php echo $item->getOrderId(); ?></span>
                        </a>

                    </td>
                    <td class="visible-md visible-lg">
                        <?php $reference = $item->getShopId(); ?>
                        <span><?php echo $reference; ?></span>
                    </td>
                    <td class="visible-md visible-lg">
                        <?php $reference = $item->getProductsCount(); ?>
                        <span><?php echo $reference; ?></span>
                    </td>
                    <td class="visible-md visible-lg"><?php echo $item->getTotalProducts(); ?></td>
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
