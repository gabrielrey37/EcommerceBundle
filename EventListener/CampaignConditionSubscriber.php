<?php

/*
 * @copyright   2016 Mautic Contributors. All rights reserved
 * @author      Mautic, Inc.
 *
 * @link        https://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace MauticPlugin\EcommerceBundle\EventListener;

use Mautic\CampaignBundle\CampaignEvents;
use Mautic\CampaignBundle\Event\CampaignBuilderEvent;
use Mautic\CampaignBundle\Event\CampaignExecutionEvent;
use Mautic\EmailBundle\EmailEvents;
use Mautic\EmailBundle\Exception\InvalidEmailException;
use Mautic\EmailBundle\Helper\EmailValidator;
use MauticPlugin\EcommerceBundle\Model\CartModel;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CampaignConditionSubscriber implements EventSubscriberInterface
{

    private $cartModel;

    public function __construct(CartModel $cartModel)
    {
        $this->cartModel = $cartModel;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            CampaignEvents::CAMPAIGN_ON_BUILD                => ['onCampaignBuild', 0],
            'mautic.ecommerce.on_campaign_trigger_condition' => ['onCampaignTriggerCondition', 0],
        ];
    }

    public function onCampaignBuild(CampaignBuilderEvent $event)
    {
        $event->addCondition(
            'ecommerce.validate.address',
            [
                'label'       => 'mautic.ecommerce.campaign.event.abandoned_cart',
                'description' => 'mautic.ecommerce.campaign.event.abandoned_cart_descr',
                'eventName'   => 'mautic.ecommerce.on_campaign_trigger_condition',
            ]
        );
    }

    public function onCampaignTriggerCondition(CampaignExecutionEvent $event)
    {
        return $event->setResult(true);

        return $event->setResult(false);
    }
}
