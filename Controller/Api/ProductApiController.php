<?php

namespace MauticPlugin\EcommerceBundle\Controller\Api;

use Mautic\ApiBundle\Controller\CommonApiController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

/**
 * Class AssetApiController.
 */
class ProductApiController extends CommonApiController
{
    
    public function initialize(FilterControllerEvent $event)
    {
        $this->model            = $this->getModel('product');
        $this->entityClass      = 'MauticPlugin\EcommerceBundle\Entity\Product';
        $this->entityNameOne    = 'product';
        $this->entityNameMulti  = 'products';
        $this->permissionBase    = 'ecommerce:product';
        $this->dataInputMasks   = [
            'shortDescription'  => 'html',
            'longDescription'   => 'html',
        ];

        parent::initialize($event);
    }
    
    public function getProductByIdAction($id, $shopId)
    {
        $entity = $this->model->getProductById($id, $shopId);
        
        if (null === $entity) {
            return $this->notFound();
        }
        
        if (count($entity) != 1) {
            return $this->notFound(); //TODO ERROR
        }
/*
        if (!$this->get('mautic.security')->hasEntityAccess('product:product:viewown', 'product:product:viewother', $entity->getPermissionUser())) {
            return $this->accessDenied();
        }*/

        //$companies = $this->model->getProductById($entity);

        $view = $this->view($entity[0],Response::HTTP_OK);

        return $this->handleView($view);
    }

}
