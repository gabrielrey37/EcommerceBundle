<?php


$view->extend('MauticCoreBundle:Default:content.html.php');

$header = ($entity->getId()) ?
    $view['translator']->trans('mautic.ecommerce.product.menu.edit',
        ['%name%' => $entity->getName()]) :
    $view['translator']->trans('mautic.ecommerce.product.menu.new');
$header = $header;
$view['slots']->set('headerTitle', $header);
$view['slots']->set('mauticContent', 'product');
?>

<?php echo $view['form']->start($form); ?>
<!-- start: box layout -->
<div class="box-layout">
    <!-- container -->
    <div class="col-md-9 bg-auto height-auto bdr-r">
        <div class="pa-md">
		    <div class="row">
				<div class="col-md-6">
                    <img src="<?php echo $view['assets']->getUrl('plugins/PrestashopEcommerceBundle/Assets/img/products/' . $entity->getImageUrl()) ?>" alt="<?php echo $entity->getName(); ?>" class="img-thumbnail" />
					<?php echo $view['form']->row($form['imageUrl']); ?>
                    <?php echo $view['form']->row($form['url']); ?>
                    <?php echo $view['form']->row($form['reference']); ?>
				</div>
				<div class="col-md-6">
                    <?php echo $view['form']->row($form['name']); ?>
					<?php echo $view['form']->row($form['productId']); ?>
                    <?php echo $view['form']->row($form['productAttributeId']); ?>
                    <?php echo $view['form']->row($form['shopId']); ?>
                    <?php echo $view['form']->row($form['price']); ?>
                    <?php echo $view['form']->row($form['taxPercent']); ?>
				</div>
			</div>
            <div class="row">
                <div class="col-xs-12">
                    <?php echo $view['form']->row($form['shortDescription']); ?>
                    <?php echo $view['form']->row($form['longDescription']); ?>
                </div>
            </div>
		</div>
	</div>
 	<div class="col-md-3 bg-white height-auto">
		<div class="pr-lg pl-lg pt-md pb-md">
			<?php
            echo $view['form']->row($form['isPublished']);
            echo $view['form']->row($form['category']);
            echo $view['form']->row($form['language']);
            echo $view['form']->row($form['publishUp']);
            echo $view['form']->row($form['publishDown']);
            ?>
		</div>
	</div>
</div>
<?php echo $view['form']->end($form); ?>

