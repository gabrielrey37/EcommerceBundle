<?php

namespace MauticPlugin\EcommerceBundle\Controller;

use Mautic\CoreBundle\Controller\AjaxController as CommonAjaxController;
use Mautic\CoreBundle\Helper\InputHelper;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AjaxController.
 */
class AjaxController extends CommonAjaxController
{
    protected function categoryListAction(Request $request)
    {
        $filter    = InputHelper::clean($request->query->get('filter'));
        $results   = $this->getModel('asset')->getLookupResults('category', $filter, 10);
        $dataArray = [];
        foreach ($results as $r) {
            $dataArray[] = [
                'label' => $r['title']." ({$r['id']})",
                'value' => $r['id'],
            ];
        }

        return $this->sendJsonResponse($dataArray);
    }

 
}
