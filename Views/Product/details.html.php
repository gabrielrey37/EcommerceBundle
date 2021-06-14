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
$view['slots']->set('mauticContent', 'product');
$view['slots']->set('headerTitle', $item->getName());

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
                                            'product.product.productId'
                                        ); ?></span></td>
                                <td><?php echo $item->getProductId(); ?></td>
                            </tr>
                            <tr>
                                <td width="20%"><span class="fw-b"><?php echo $view['translator']->trans(
                                            'product.product.shopId'
                                        ); ?></span></td>
                                <td><?php echo $item->getShopId(); ?></td>
                            </tr>
                            <tr>
                                <td width="20%"><span class="fw-b"><?php echo $view['translator']->trans(
                                            'product.product.productAttributeId'
                                        ); ?></span></td>
                                <td><?php echo $item->getProductAttributeId(); ?></td>
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

            <!-- some stats -->
            <div class="pa-md">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel">
                            <div class="panel-body box-layout">
                                <div class="col-md-2 va-m">
                                    <h5 class="text-white dark-md fw-sb mb-xs">
                                        <span class="fa fa-chrome"></span>
                                        <?php echo $view['translator']->trans('mautic.ecommerce.graph.product.line.views'); ?>
                                    </h5>
                                </div>
                                
                                
                                <div class="col-md-8 va-m">
                                    <?php echo $view->render('MauticCoreBundle:Helper:graph_dateselect.html.php', ['dateRangeForm' => $dateRangeForm, 'class' => 'pull-right']); ?>
                                </div>
                            </div>
                            <div class="pt-0 pl-15 pb-10 pr-15">
                                <?php echo $view->render('MauticCoreBundle:Helper:chart.html.php', ['chartData' => $stats, 'chartType' => 'line', 'chartHeight' => 300]); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ stats -->

        </div>

        <?php echo $view['content']->getCustomContent('details.stats.graph.below', $mauticTemplateVars); ?>

        <!-- start: tab-content -->
        <div class="tab-content pa-md preview-detail">
            <div class="row">
                <div class="col-md-6">
                    <img src="<?php echo $view['assets']->getUrl('plugins/PrestashopEcommerceBundle/Assets/img/products/' . $item->getImageUrl()) ?>" alt="<?php echo $item->getName(); ?>" class="img-thumbnail" />
                </div>
                
                <div class="col-md-6">
                    <h6><strong><?php echo $view['translator']->trans('mautic.ecommerce.reference'); ?></strong></h6>
                    <p><?php echo $item->getReference(); ?></p>
                    <h6><strong><?php echo $view['translator']->trans('mautic.ecommerce.product.shortDescription'); ?></strong></h6>
                    <p><?php echo $item->getShortDescription(); ?></p>
                    <h6><strong><?php echo $view['translator']->trans('mautic.ecommerce.price'); ?></strong></h6>
                    <p><?php echo '$ ' .number_format($item->getPrice(), 2); //TODO CURRENCY ?></p>
                    <h6><strong><?php echo $view['translator']->trans('mautic.ecommerce.product.taxPercent'); ?></strong></h6>
                    <p><?php echo '% ' . $item->getTaxPercent(); ?></p>
                    <h6><strong><?php echo $view['translator']->trans('mautic.ecommerce.product.longDescription'); ?></strong></h6>
                    <p><?php echo $item->getLongDescription(); ?></p>
                    <h6><strong><?php echo $view['translator']->trans('mautic.ecommerce.url'); ?></strong></h6>
                    <p><?php echo $item->getUrl(); ?></p>
                </div>
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
