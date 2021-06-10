<?php

/*
 * @copyright   2014 Mautic Contributors. All rights reserved
 * @author      Mautic
 *
 * @link        http://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
$view->extend('MauticCoreBundle:Default:content.html.php');
$view['slots']->set('mauticContent', 'order');
$view['slots']->set('headerTitle', $item->getOrderId());

?>

<!-- start: box layout -->
<div class="box-layout">
    <!-- left section -->
    <div class="col-md-9 bg-white height-auto">
        <div class="bg-auto">
            <!-- asset detail collapseable -->
            <div class="collapse" id="product-details">
                <div class="pr-md pl-md pb-md">
                    <div class="panel shd-none mb-0">
                        <table class="table table-bordered table-striped mb-0">
                            <tbody>
                            <?php echo $view->render(
                                'MauticCoreBundle:Helper:details.html.php',
                                ['entity' => $item]
                            ); ?>
                            <tr>
                                <td width="20%"><span class="fw-b"><?php echo $view['translator']->trans(
                                            'mautic.ecommerce.orderId'
                                        ); ?></span></td>
                                <td><?php echo $item->getOrderId(); ?></td>
                            </tr>
                            <tr>
                                <td width="20%"><span class="fw-b"><?php echo $view['translator']->trans(
                                            'mautic.ecommerce.shopId'
                                        ); ?></span></td>
                                <td><?php echo $item->getShopId(); ?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!--/ asset detail collapseable -->
        </div>

        <div class="bg-auto bg-dark-xs">
            <!-- asset detail collapseable toggler -->
            <div class="hr-expand nm">
                <span data-toggle="tooltip" title="Detail">
                    <a href="javascript:void(0)" class="arrow text-muted collapsed" data-toggle="collapse"
                       data-target="#product-details"><span class="caret"></span> <?php echo $view['translator']->trans(
                            'mautic.core.details'
                        ); ?></a>
                </span>
            </div>
            <!--/ asset detail collapseable toggler -->

        </div>

        <?php echo $view['content']->getCustomContent('details.stats.graph.below', $mauticTemplateVars); ?>

        <!-- start: tab-content -->
        <div class="tab-content pa-md preview-detail">
            <div class="row">
                <div class="col-md-6">
                    <h6><?php echo $view['translator']->trans('mautic.ecommerce.order.orderId'); ?></h6>
                    <p><?php echo $item->getOrderId(); ?></p>
                </div>
                
                <div class="col-md-6">
                    <h6><?php echo $view['translator']->trans('mautic.ecommerce.order.reference'); ?></h6>
                    <p><?php echo $item->getReference(); ?></p>
                </div>
            </div>
            <div class="row">
                <table class="table table-hover table-striped table-bordered product-list" id="productTable">
                    <thead>
                    <tr>
                        <?php
                        echo $view->render(
                            'MauticCoreBundle:Helper:tableheader.html.php',
                            [
                                'sessionVar' => 'orderline',
                                'text'       => 'mautic.ecommerce.image',
                                //'orderBy'    => 'ord.orderId',
                                //'class'      => 'col-product-image',
                                //'default'    => false,
                            ]
                        );


                        echo $view->render(
                            'MauticCoreBundle:Helper:tableheader.html.php',
                            [
                                'sessionVar' => 'orderline',
                                'text'       => 'mautic.ecommerce.product',
                                //'orderBy'    => 'ord.orderId',
                                //'class'      => 'col-product-image',
                                //'default'    => false,
                            ]
                        );

                        echo $view->render(
                            'MauticCoreBundle:Helper:tableheader.html.php',
                            [
                                'sessionVar' => 'orderline',
                                //'orderBy'    => 'ord.shopId',
                                'text'       => 'mautic.ecommerce.quantity',
                                //'class'      => 'col-product-name',
                                //'default'    => true,
                            ]
                        );

                        echo $view->render(
                            'MauticCoreBundle:Helper:tableheader.html.php',
                            [
                                'sessionVar' => 'orderline',
                                'text'       => 'mautic.ecommerce.unitprice',
                                //'class'      => 'col-product-name',
                                //'default'    => false,
                            ]
                        );

                        echo $view->render(
                            'MauticCoreBundle:Helper:tableheader.html.php',
                            [
                                'sessionVar' => 'orderline',
                                'text'       => 'mautic.ecommerce.total',
                                //'class'      => 'col-product-name',
                                //'default'    => false,
                            ]
                        );
                        ?>
                    </tr>

                    </thead>
                    <tbody>
                    <?php $total=0; ?>
                    <?php foreach ($item->getOrderRows() as $k => $row): ?>
                        <?php //echo dump($row); ?>
                        <tr>
                            <td class="visible-md visible-lg">

                                <a href="<?php echo $view['router']->path(
                                    'mautic_product_action',
                                    ['objectAction' => 'view', 'objectId' => $row->getProductId()->getId()]
                                ); ?>"
                                >
                                    <img src="<?php echo $view['assets']->getUrl('plugins/PrestashopEcommerceBundle/Assets/img/products/' . $row->getProductId()->getImageUrl()) ?>" alt="<?php echo $row->getProductId()->getName(); ?>" class="img-thumbnail" style="max-width: 100px; display: block; margin: auto"/>
                                </a>

                            </td>
                            <td class="visible-md visible-lg">
                                <a href="<?php echo $view['router']->path(
                                    'mautic_product_action',
                                    ['objectAction' => 'view', 'objectId' => $row->getProductId()->getId()]
                                ); ?>"
                                >
                                    <span><?php echo $row->getProductId()->getName(); ?></span></span>
                                </a>

                            </td>
                            <td class="visible-md visible-lg">
                                <span><?php echo $row->getProductQuantity(); ?></span></span>
                            </td>
                            <td class="visible-md visible-lg"><?php echo $row->getProductPrice(); ?></td>
                            <td class="visible-md visible-lg">
                                <?php $totalRow=((float)$row->getProductPrice() * (float)$row->getProductQuantity()); ?>
                                <?php $total= $total + $totalRow; ?>
                                <?php echo $totalRow; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="3" style="visibility:hidden;"></td>
                        <td><?php echo$view['translator']->trans('mautic.ecommerce.total');?></td>
                        <td><?php echo $item->getTotalProducts(); ?></td>
                    </tr>
                    <tr>
                        <td colspan="3" style="visibility:hidden;"></td>
                        <td><?php echo$view['translator']->trans('mautic.ecommerce.shipping');?></td>
                        <td><?php echo $item->getTotalShipping(); ?></td>
                    </tr>
                    <tr>
                        <td colspan="3" style="visibility:hidden;"></td>
                        <td><?php echo$view['translator']->trans('mautic.ecommerce.totalPaid');?></td>
                        <td><?php echo $item->getTotalPaid(); ?></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!--/ end: tab-content -->

    </div>
    <!--/ left section -->

    <!-- right section -->
    <div class="col-md-3 bg-white bdr-l height-auto">
        <!-- activity feed -->
        <?php echo $view->render('MauticCoreBundle:Helper:recentactivity.html.php', ['logs' => $logs]); ?>
    </div>
    <!--/ right section -->
    <input name="entityId" id="entityId" type="hidden" value="<?php echo $view->escape($item->getId()); ?>"/>
</div>
<!--/ end: box layout -->
