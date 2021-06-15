<div class="tab-pane fade bdr-w-0" id="ecommerce-container">
    <div class="col-md-6">
        <h3 class="pb-5"><?php
            echo $view['translator']->trans('mautic.ecommerce.cart.lastcarts');
            ?>
        </h3>
        <table class="table table-hover table-striped table-bordered">
            <thead>
            <tr>
                <th>
                    <?php
                    echo $view['translator']->trans('mautic.core.id');
                    ?>
                </th>
                <th>
                    <?php
                    echo $view['translator']->trans('mautic.ecommerce.order');
                    ?>
                </th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($carts as $cart): ?>
            <tr>
            <td class="">
                <a href="<?php echo $view['router']->path(
                    'mautic_cart_action',
                    ['objectAction' => 'view', 'objectId' => $cart->getId()]
                ); ?>"
                >
                    <span><?php echo $cart->getId(); ?></span>
                </a>
            </td>
            <td class=""><?php
                $order =$cart->getOrder();
                if ($order){
                    ?>
                    <a href="<?php echo $view['router']->path(
                        'mautic_order_action',
                        ['objectAction' => 'view', 'objectId' => $order->getId()]
                    ); ?>"
                    >
                        <?php echo $order->getReference(); ?>
                    </a>
                    <?php
                }
                else{
                    echo $view['translator']->trans('mautic.ecommerce.abandonedcart');
                }?>
            </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="col-md-6">
        <h3 class="pb-5"><?php
            echo $view['translator']->trans('mautic.ecommerce.cart.lastorders');
            ?>
        </h3>
        <table class="table table-hover table-striped table-bordered">
            <thead>
            <tr>
                <th>
                    <?php
                    echo $view['translator']->trans('mautic.core.id');
                    ?>
                </th>
                <th>
                    <?php
                    echo $view['translator']->trans('mautic.ecommerce.reference');
                    ?>
                </th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td class="">
                        <a href="<?php echo $view['router']->path(
                            'mautic_order_action',
                            ['objectAction' => 'view', 'objectId' => $order->getId()]
                        ); ?>"
                        >
                            <span><?php echo $order->getId(); ?></span>
                        </a>
                    </td>
                    <td class="">
                        <a href="<?php echo $view['router']->path(
                            'mautic_order_action',
                            ['objectAction' => 'view', 'objectId' => $order->getId()]
                        ); ?>"
                        >
                            <?php echo $order->getReference(); ?>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>