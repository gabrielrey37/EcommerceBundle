<?php

namespace MauticPlugin\EcommerceBundle\Controller;

use Mautic\CoreBundle\Controller\AbstractStandardFormController;
use Mautic\CoreBundle\Form\Type\DateRangeType;


class OrderController extends AbstractStandardFormController
{

    protected function getControllerBase()
    {
        return 'EcommerceBundle:Order';
    }

    protected function getModelName()
    {
        return 'order';
    }

    public function indexAction($page = 1)
    {
        return parent::indexStandard($page);
    }



    public function viewAction($objectId)
    {
        return parent::viewStandard($objectId, 'order', 'plugin.ecommerce');
    }



    public function getDefaultOrderColumn(){
        return 'id';
    }

    public function getViewArguments(array $args, $action)
    {
        if ('view' == $action) {
            $item = $args['viewParameters']['item'];

            // For line graphs in the view
            $dateRangeValues = $this->request->get('daterange', []);
            $dateRangeForm   = $this->get('form.factory')->create(
                DateRangeType::class,
                $dateRangeValues,
                [
                    'action' => $this->generateUrl(
                        'mautic_order_action',
                        [
                            'objectAction' => 'view',
                            'objectId'     => $item->getId(),
                        ]
                    ),
                ]
            );

            $args['viewParameters']['dateRangeForm'] = $dateRangeForm->createView();

            if ('link' == $item->getType()) {
                $args['viewParameters']['trackables'] = $this->getModel('page.trackable')->getTrackableList('order', $item->getId());
            }
        }

        return $args;
    }

    protected function getPostActionRedirectArguments(array $args, $action)
    {
        $focus        = $this->request->request->get('order', []);
        $updateSelect = 'POST' === $this->request->getMethod()
            ? ($focus['updateSelect'] ?? false)
            : $this->request->get('updateSelect', false);

        if ($updateSelect) {
            switch ($action) {
                case 'new':
                case 'edit':
                    $passthrough = $args['passthroughVars'];
                    $passthrough = array_merge(
                        $passthrough,
                        [
                            'updateSelect' => $updateSelect,
                            'id'           => $args['entity']->getId(),
                            //'name'         => $args['entity']->getName(),
                        ]
                    );
                    $args['passthroughVars'] = $passthrough;
                    break;
            }
        }

        return $args;
    }

    protected function getEntityFormOptions()
    {
        $focus        = $this->request->request->get('order', []);
        $updateSelect = 'POST' === $this->request->getMethod()
            ? ($focus['updateSelect'] ?? false)
            : $this->request->get('updateSelect', false);

        if ($updateSelect) {
            return ['update_select' => $updateSelect];
        }
    }


    protected function getUpdateSelectParams($updateSelect, $entity, $nameMethod = 'getId', $groupMethod = 'getLanguage')
    {
        return [
            'updateSelect' => $updateSelect,
            'id'           => $entity->getId(),
            'name'         => $entity->$nameMethod(),
        ];
    }
}
