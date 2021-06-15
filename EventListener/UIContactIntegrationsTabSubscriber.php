<?php


namespace MauticPlugin\EcommerceBundle\EventListener;


use Mautic\CoreBundle\CoreEvents;
use Mautic\CoreBundle\Event\CustomContentEvent;
use Mautic\CoreBundle\Event\CustomTemplateEvent;
use MauticPlugin\EcommerceBundle\Model\CartModel;
use MauticPlugin\EcommerceBundle\Model\OrderModel;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UIContactIntegrationsTabSubscriber implements EventSubscriberInterface
{
    private $cartModel;

    private $orderModel;

    public function __construct(CartModel $cartModel, OrderModel $orderModel)
    {
        $this->cartModel = $cartModel;
        $this->orderModel = $orderModel;
    }
    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * ['eventName' => 'methodName']
     *  * ['eventName' => ['methodName', $priority]]
     *  * ['eventName' => [['methodName1', $priority], ['methodName2']]]
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return [
            CoreEvents::VIEW_INJECT_CUSTOM_CONTENT => ['onTemplateRender', 0],
        ];
    }

    public function onTemplateRender(CustomContentEvent  $event): void
    {
        //var_dump($event->getViewName());

        if ($event->checkContext('MauticLeadBundle:Lead:lead.html.php','tabs')){
            $content = '<li class=""><a href="#ecommerce-container" role="tab" data-toggle="tab">Ecommerce</a></li>';
            $event->addContent($content);
         }

        if ($event->checkContext('MauticLeadBundle:Lead:lead.html.php','tabs.content')){
            $carts = $this->cartModel->getCartsByLead($event->getVars()['lead']);
            $orders = $this->orderModel->getOrdersByLead($event->getVars()['lead']);
            $vars['carts'] = $carts;
            $vars['orders'] = $orders;
            $event->addTemplate('EcommerceBundle:Lead:summary.html.php',$vars);
        }
        /*
        die();
        if ('MauticLeadBundle:Lead:lead.html.php' === $event->getTemplate()) {
            $vars         = $event->getVars();
            var_dump($vars);
            die();
        }*/
    }
}