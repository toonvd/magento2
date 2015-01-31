<?php

namespace Phpro\Customernumber\Model\Plugin;

use Magento\Customer\Model\Customer as CustomerModel;
use Phpro\Customernumber\Helper\Data as CustomerNumberHelper;

/**
 * Class AccountManagement
 * @package Phpro\Loginquotehandler\Model\Plugin
 */
class AccountManagement
{
    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $customerModel;
    /**
     * @var mixed
     */
    protected $helper;

    /**
     * @param CustomerModel $customerModel
     * @param CustomerNumberHelper $customerNumberHelper
     */
    public function __construct(CustomerModel $customerModel, CustomerNumberHelper $customerNumberHelper)
    {
        $this->customerModel = $customerModel;
        $this->helper = $customerNumberHelper;
    }

    /**
     * @param $subject
     * @param $result
     * @return mixed
     */
    public function afterAuthenticate($subject, $result)
    {
        try {
            $this->_addClientNumberToCustomerIfNotExists($result);
        } catch (Exception $e) {
            $this->helper->error($e->getMessage());
        }
        return $result;
    }


    /**
     * @param $customerSession
     * @return bool
     */
    protected function _addClientNumberToCustomerIfNotExists($customerSession)
    {
        $customerModel = $this->customerModel;
        $customer = $customerModel->load($customerSession->getId());
        if (!$customer->hasCustomerNumber()) {
            //this should be a webservice call
            $customer->setCustomerNumber('testCustomerId1234');
            $customer->save();
        }
    }
}

