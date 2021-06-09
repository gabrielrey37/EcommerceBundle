<?php

namespace MauticPlugin\EcommerceBundle;


final class ProductEvents
{
    /**
     * The mautic.ecommerce.on_campaign_trigger_condition event is fired when the campaign condition triggers.
     *
     * The event listener receives a
     * MauticPlugin\EcommerceBundle\Event\CampaignExecutionEvent
     *
     * @var string
     */
    const ON_CAMPAIGN_TRIGGER_CONDITION = 'mautic.ecommerce.on_campaign_trigger_condition';
}
