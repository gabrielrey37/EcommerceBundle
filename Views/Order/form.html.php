<?php


$view->extend('MauticCoreBundle:Default:content.html.php');

$header = ($entity->getId()) ?
    $view['translator']->trans('mautic.ecommerce.order.menu.edit',
        ['%name%' => $entity->getId()]) :
    $view['translator']->trans('mautic.ecommerce.order.menu.new');
$header = $header;
$view['slots']->set('headerTitle', $header);
$view['slots']->set('mauticContent', 'order');
?>

<?php echo $view['form']->start($form); ?>
<!-- start: box layout -->
<div class="box-layout">
    <!-- container -->
    <div class="col-md-9 bg-auto height-auto bdr-r">
        <div class="pa-md">
		    <div class="row">
				<div class="col-md-6">
					<?php echo $view['form']->row($form['orderId']); ?>
				</div>
				<div class="col-md-6">
                    <?php echo $view['form']->row($form['carrierId']); ?>
                    <?php echo $view['form']->row($form['shopId']); ?>
				</div>
			</div>
            <div class="row">
                <div class="col-xs-12">
                    <?php echo $view['form']->row($form['orderLines']); ?>
                </div>
            </div>
		</div>
	</div>
 	<div class="col-md-3 bg-white height-auto">
		<div class="pr-lg pl-lg pt-md pb-md">
			<?php
            ?>
		</div>
	</div>
</div>
<?php echo $view['form']->end($form); ?>

