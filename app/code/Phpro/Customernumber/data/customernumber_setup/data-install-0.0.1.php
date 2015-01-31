<?php
/* @var Magento\Customer\Model\Resource\Setup */
$installer = $this;
$installer->startSetup();

$installer->addAttribute(
    'customer',
    'customer_number',
    [
        'type' => 'text',
        'input' => 'text',
        'validate_rules' => '',
        'visible' => false,
        'required' => false
    ]
);

$installer->endSetup();