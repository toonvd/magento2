<?php
namespace Phpro\Customernumber\Helper;

/**
 * Class Data
 * @package Phpro\Loginquotehandler\Helper
 */
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{


    /**
     * @param $message
     * @param array $context
     *
     * Usage: $this->helper->debug('whateveryouwanttodebug'); (dependency injection of helper in constructor)
     */
    public function debug($message, $context = array())
    {
        $this->_logger->debug($message, $context);
    }


    /**
     * @param $message
     * @param array $context
     *
     * Usage: $this->helper->error('erroryouwanttolog'); (dependency injection of helper in constructor)
     */
    public function error($message, $context = array())
    {
        $this->_logger->error($message, $context);
    }
}