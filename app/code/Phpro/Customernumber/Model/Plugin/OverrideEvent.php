<?php

namespace Phpro\Customernumber\Model\Plugin;

/**
 * Class OverrideEvent
 * @package Phpro\Loginquotehandler\Model\Plugin
 */
class OverrideEvent
{
    /**
     * @param $subject
     * @param $eventName
     * @param array $data
     * @return mixed
     */
    public function beforeDispatch($subject, $eventName, array $data = [])
    {
        if ($eventName == "customer_customer_authenticated") {
            $eventName = "phpro_customer_customer_authenticated";
            $data = ['test'];
        }
        return array($eventName, $data);
    }
}