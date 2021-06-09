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
$view['slots']->set('headerTitle', $view['translator']->trans('mautic.ecommerce.products'));

$view['slots']->set(
    'actions',
    $view->render(
        'MauticCoreBundle:Helper:page_actions.html.php',
        [
            'templateButtons' => [
                'new' => $permissions['ecommerce:products:create'],
            ],
            'routeBase' => 'product',
        ]
    )
);

$toolbarButtons[] = [
    'attr' => [
        'class'          => 'hidden-xs btn btn-default btn-sm btn-nospin',
        'href'           => 'javascript: void(0)',
        'onclick'        => 'Mautic.toggleCombinations();',
        'id'             => 'anonymousLeadButton',
        'data-anonymous' => $view['translator']->trans('mautic.ecommerce.product.searchcommand.showcombinations'),
    ],
    'tooltip'   => $view['translator']->trans('mautic.lead.lead.anonymous_leads'),
    'iconClass' => 'fa fa-user-secret',
];

?>

<div class="panel panel-default bdr-t-wdh-0 mb-0">
    <?php echo $view->render('MauticCoreBundle:Helper:list_toolbar.html.php', [
        'searchValue' => $searchValue,
        'action'      => $currentRoute,
        'customButtons' => $toolbarButtons,
        'searchHelp'  => 'ecommerce.products.help.searchcommands',
    ]); ?>
    <div class="page-list">
        <?php $view['slots']->output('_content'); ?>
    </div>
</div>
