<?php

namespace MauticPlugin\EcommerceBundle\Model;

use Mautic\CoreBundle\Helper\CookieHelper;
use Mautic\CoreBundle\Helper\CoreParametersHelper;
use Mautic\CoreBundle\Helper\DateTimeHelper;
use Mautic\CoreBundle\Helper\IpLookupHelper;
use Mautic\LeadBundle\Model\CompanyModel;
use Mautic\LeadBundle\Model\FieldModel;
use Mautic\LeadBundle\Model\LeadModel;
use Mautic\LeadBundle\Tracker\ContactTracker;
use Mautic\LeadBundle\Tracker\DeviceTracker;
use Mautic\PageBundle\Model\RedirectModel;
use Mautic\PageBundle\Model\TrackableModel;
use Mautic\QueueBundle\Queue\QueueService;
use MauticPlugin\EcommerceBundle\Entity\OverrideHit;

use Mautic\PageBundle\Model\PageModel;
use Mautic\LeadBundle\Entity\Company;
use Mautic\LeadBundle\Entity\Lead;
use Mautic\LeadBundle\Helper\IdentifyCompanyHelper;
use Mautic\PageBundle\Entity\Page;
use Mautic\PageBundle\Entity\Redirect;
use Mautic\QueueBundle\Queue\QueueName;
use Symfony\Component\HttpFoundation\Request;

class OverridePageModel extends PageModel
{
    private $companyModel;
    private $deviceTracker;
    private $contactTracker;

    public function __construct(
        CookieHelper $cookieHelper,
        IpLookupHelper $ipLookupHelper,
        LeadModel $leadModel,
        FieldModel $leadFieldModel,
        RedirectModel $pageRedirectModel,
        TrackableModel $pageTrackableModel,
        QueueService $queueService,
        CompanyModel $companyModel,
        DeviceTracker $deviceTracker,
        ContactTracker $contactTracker,
        CoreParametersHelper $coreParametersHelper
    ) {
        $this->cookieHelper         = $cookieHelper;
        $this->ipLookupHelper       = $ipLookupHelper;
        $this->leadModel            = $leadModel;
        $this->leadFieldModel       = $leadFieldModel;
        $this->pageRedirectModel    = $pageRedirectModel;
        $this->pageTrackableModel   = $pageTrackableModel;
        $this->dateTimeHelper       = new DateTimeHelper();
        $this->queueService         = $queueService;
        $this->companyModel         = $companyModel;
        $this->deviceTracker        = $deviceTracker;
        $this->contactTracker       = $contactTracker;
        $this->coreParametersHelper = $coreParametersHelper;
    }
    public function hitPage($page, Request $request, $code = '200', Lead $lead = null, $query = [])
    {
        // Don't skew results with user hits
        if (!$this->security->isAnonymous()) {
            return;
        }

        // Process the query
        if (empty($query)) {
            $query = $this->getHitQuery($request, $page);
        }

        // Get lead if required
        if (null == $lead) {
            $lead = $this->leadModel->getContactFromRequest($query);

            // company
            list($company, $leadAdded, $companyEntity) = IdentifyCompanyHelper::identifyLeadsCompany($query, $lead, $this->companyModel);
            if ($leadAdded) {
                $lead->addCompanyChangeLogEntry('form', 'Identify Company', 'Lead added to the company, '.$company['companyname'], $company['id']);
            } elseif ($companyEntity instanceof Company) {
                $this->companyModel->setFieldValues($companyEntity, $query);
                $this->companyModel->saveEntity($companyEntity);
            }

            if (!empty($company) and $companyEntity instanceof Company) {
                // Save after the lead in for new leads created through the API and maybe other places
                $this->companyModel->addLeadToCompany($companyEntity, $lead);
                $this->leadModel->setPrimaryCompany($companyEntity->getId(), $lead->getId());
            }
        }

        if (!$lead || !$lead->getId()) {
            // Lead came from a non-trackable IP so ignore
            return;
        }

        $hit = new OverrideHit();
        
        $hit->setDateHit(new \Datetime());
        $hit->setIpAddress($this->ipLookupHelper->getIpAddress());
        
        $hit->setProductId(isset($query['productId']) ? (int)$query['productId'] : 0);
        $hit->setProductAttributeId(isset($query['productAttributeId']) ? (int)$query['productAttributeId'] : 0);
        $hit->setShopId(isset($query['shopId']) ? (int)$query['shopId'] : 0);
        
        // Set info from request
        $hit->setQuery($query);
        $hit->setCode($code);

        $trackedDevice = $this->deviceTracker->createDeviceFromUserAgent($lead, $request->server->get('HTTP_USER_AGENT'));

        $hit->setTrackingId($trackedDevice->getTrackingId());
        $hit->setDeviceStat($trackedDevice);

        // Wrap in a try/catch to prevent deadlock errors on busy servers
        try {
            $this->em->persist($hit);
            $this->em->flush();
        } catch (\Exception $exception) {
            if (MAUTIC_ENV === 'dev') {
                throw $exception;
            } else {
                $this->logger->addError(
                    $exception->getMessage(),
                    ['exception' => $exception]
                );
            }
        }

        //save hit to the cookie to use to update the exit time
        if ($hit) {
            $this->cookieHelper->setCookie('mautic_referer_id', $hit->getId() ?: null);
        }

        if ($this->queueService->isQueueEnabled()) {
            $msg = [
                'hitId'         => $hit->getId(),
                'pageId'        => $page ? $page->getId() : null,
                'request'       => $request,
                'leadId'        => $lead ? $lead->getId() : null,
                'isNew'         => $this->deviceTracker->wasDeviceChanged(),
                'isRedirect'    => ($page instanceof Redirect),
            ];
            $this->queueService->publishToQueue(QueueName::PAGE_HIT, $msg);
        } else {
            $this->processPageHit($hit, $page, $request, $lead, $this->deviceTracker->wasDeviceChanged());
        }
    }

}
