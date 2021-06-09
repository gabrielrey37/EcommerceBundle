<?php

namespace MauticPlugin\EcommerceBundle\Controller;

use Mautic\CoreBundle\Controller\AbstractStandardFormController;
use Mautic\CoreBundle\Form\Type\DateRangeType;
use MauticPlugin\MauticFocusBundle\Entity\Focus;
use MauticPlugin\MauticFocusBundle\Model\FocusModel;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;


class ProductController extends AbstractStandardFormController
{

    protected function getControllerBase()
    {
        return 'EcommerceBundle:Product';
    }

    protected function getModelName()
    {
        return 'product';
    }

    public function indexAction($page = 1)
    {
        return parent::indexStandard($page);
    }

    public function newAction()
    {
        return parent::newStandard();
    }

    public function editAction($objectId, $ignorePost = false)
    {
        return parent::editStandard($objectId, $ignorePost);
    }

    public function viewAction($objectId)
    {
        return parent::viewStandard($objectId, 'product', 'plugin.ecommerce');
    }

    public function cloneAction($objectId)
    {
        return parent::cloneStandard($objectId);
    }

    public function deleteAction($objectId)
    {
        return parent::deleteStandard($objectId);
    }

    public function batchDeleteAction()
    {
        return parent::batchDeleteStandard();
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
                        'mautic_product_action',
                        [
                            'objectAction' => 'view',
                            'objectId'     => $item->getId(),
                        ]
                    ),
                ]
            );

            $model = $this->getModel('product');
            $stats = $model->getViewsLineChartData(
                null,
                new \DateTime($dateRangeForm->get('date_from')->getData()),
                new \DateTime($dateRangeForm->get('date_to')->getData()),
                null,
                ['product_Id' => $item->getProductId()]
            );

            $args['viewParameters']['stats']         = $stats;
            $args['viewParameters']['dateRangeForm'] = $dateRangeForm->createView();

            if ('link' == $item->getType()) {
                $args['viewParameters']['trackables'] = $this->getModel('page.trackable')->getTrackableList('product', $item->getId());
            }
        }

        return $args;
    }

    protected function getPostActionRedirectArguments(array $args, $action)
    {
        $focus        = $this->request->request->get('product', []);
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
                            'name'         => $args['entity']->getName(),
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
        $focus        = $this->request->request->get('product', []);
        $updateSelect = 'POST' === $this->request->getMethod()
            ? ($focus['updateSelect'] ?? false)
            : $this->request->get('updateSelect', false);

        if ($updateSelect) {
            return ['update_select' => $updateSelect];
        }
    }


    protected function getUpdateSelectParams($updateSelect, $entity, $nameMethod = 'getName', $groupMethod = 'getLanguage')
    {
        return [
            'updateSelect' => $updateSelect,
            'id'           => $entity->getId(),
            'name'         => $entity->$nameMethod(),
        ];
    }
}
