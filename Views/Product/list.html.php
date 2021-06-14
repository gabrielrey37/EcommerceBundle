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
    $view->extend('EcommerceBundle:Product:index.html.php');
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
                        'sessionVar' => 'product',
                        'text'       => 'mautic.ecommerce.image',
                        'class'      => 'col-product-image',
                        'default'    => false,
                    ]
                );

                echo $view->render(
                    'MauticCoreBundle:Helper:tableheader.html.php',
                    [
                        'sessionVar' => 'product',
                        'orderBy'    => 'p.name',
                        'text'       => 'mautic.core.name',
                        'class'      => 'col-product-name',
                        'default'    => true,
                    ]
                );

                echo $view->render(
                    'MauticCoreBundle:Helper:tableheader.html.php',
                    [
                        'sessionVar' => 'product',
                        'orderBy'    => 'p.reference',
                        'text'       => 'mautic.ecommerce.reference',
                        'class'      => 'visible-md visible-lg col-asset-category',
                    ]
                );
                                
                echo $view->render(
                    'MauticCoreBundle:Helper:tableheader.html.php',
                    [
                        'sessionVar' => 'product',
                        'orderBy'    => 'c.title',
                        'text'       => 'mautic.core.category',
                        'class'      => 'visible-md visible-lg col-asset-category',
                    ]
                );

                echo $view->render(
                    'MauticCoreBundle:Helper:tableheader.html.php',
                    [
                        'sessionVar' => 'product',
                        'orderBy'    => 'p.productId',
                        'text'       => 'mautic.ecommerce.externalId',
                        'class'      => 'visible-md visible-lg col-asset-id',
                    ]
                );

                echo $view->render(
                    'MauticCoreBundle:Helper:tableheader.html.php',
                    [
                        'sessionVar' => 'product',
                        'orderBy'    => 'p.id',
                        'text'       => 'mautic.ecommerce.combinationid',
                        'class'      => 'visible-md visible-lg',
                    ]
                );

                echo $view->render(
                    'MauticCoreBundle:Helper:tableheader.html.php',
                    [
                        'sessionVar' => 'product',
                        'orderBy'    => 'p.id',
                        'text'       => 'mautic.core.id',
                        'class'      => 'visible-md visible-lg col-asset-id',
                    ]
                );
                ?>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($items as $k => $item): ?>
                <tr>
                    <td class="">

                        <a href="<?php echo $view['router']->path(
                            'mautic_product_action',
                            ['objectAction' => 'view', 'objectId' => $item->getId()]
                        ); ?>" data-toggle="ajax"
                           >
                            <img src="<?php echo $view['assets']->getUrl('plugins/PrestashopEcommerceBundle/Assets/img/products/' . $item->getImageUrl()) ?>" alt="<?php echo $item->getName(); ?>" class="img-thumbnail" style="max-width: 100px; display: block; margin: auto"/>
                        </a>

                    </td>
                    <td>
                        <div>
                            <a href="<?php echo $view['router']->path(
                                'mautic_product_action',
                                ['objectAction' => 'view', 'objectId' => $item->getId()]
                            ); ?>"
                               data-toggle="ajax">
                                <?php echo $item->getName(); ?>
                            </a>
                        </div>
                        <?php if ($description = $item->getShortDescription()): ?>
                            <div class="text-muted mt-4">
                                <small><?php echo $description; ?></small>
                            </div>
                        <?php endif; ?>
                    </td>
                    <td class="visible-md visible-lg">
                        <?php $reference = $item->getReference(); ?>
                        <span><?php echo $reference; ?></span></span>
                    </td>
                    <td class="visible-md visible-lg">
                        <?php $category = $item->getCategory(); ?>
                        <?php $catName  = ($category) ? $category->getTitle() : $view['translator']->trans('mautic.core.form.uncategorized'); ?>
                        <?php $color    = ($category) ? '#'.$category->getColor() : 'inherit'; ?>
                        <span style="white-space: nowrap;"><span class="label label-default pa-4" style="border: 1px solid #d5d5d5; background: <?php echo $color; ?>;"> </span> <span><?php echo $catName; ?></span></span>
                    </td>
                    <td class="visible-md visible-lg"><?php echo $item->getProductId(); ?></td>
                    <td class="visible-md visible-lg"><?php echo $item->getProductAttributeId(); ?></td>
                    <td class="visible-md visible-lg"><?php echo $item->getId(); ?></td>
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
                'menuLinkId' => 'mautic_product_index',
                'baseUrl'    => $view['router']->path('mautic_product_index'),
                'sessionVar' => 'product',
            ]
        ); ?>
    </div>
<?php else: ?>
    <?php echo $view->render('MauticCoreBundle:Helper:noresults.html.php', ['tip' => 'mautic.ecommerce.noresults.tip']); ?>
<?php endif; ?>

<?php echo $view->render(
    'MauticCoreBundle:Helper:modal.html.php',
    [
        'id'     => 'ProductPreviewModal',
        'header' => false,
    ]
);
