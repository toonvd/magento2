<?php
namespace Phpro\Customernumber\Model;

use Phpro\Customernumber\Helper\Data as CustomerNumberHelper;

/**
 * Class Data
 * @package Phpro\Loginquotehandler\Helper
 */
class Observer
{
    /**
     * @var mixed
     */
    protected $helper;

    /**
     * @param CustomerNumberHelper $CustomerNumberHelper
     */
    public function __construct(CustomerNumberHelper $CustomerNumberHelper)
    {
        $this->helper = $CustomerNumberHelper;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     */
    public function checkAuthenticated(\Magento\Framework\Event\Observer $observer)
    {
        $this->helper->debug('This overridden function works!');
    }
}