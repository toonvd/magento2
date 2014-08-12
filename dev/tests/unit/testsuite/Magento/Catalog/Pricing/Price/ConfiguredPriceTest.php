<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @copyright   Copyright (c) 2014 X.commerce, Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Magento\Catalog\Pricing\Price;

/**
 * Test for \Magento\Catalog\Pricing\Price\ConfiguredPrice
 */
class ConfiguredPriceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var float
     */
    protected $basePriceValue = 800.;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $item;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $product;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $calculator;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $priceInfo;

    /**
     * @var ConfiguredPrice
     */
    protected $model;

    /**
     * Initialize base dependencies
     */
    protected function setUp()
    {
        $basePrice = $this->getMock('Magento\Framework\Pricing\Price\PriceInterface', [], [], '', false);
        $basePrice->expects($this->any())->method('getValue')->will($this->returnValue($this->basePriceValue));

        $this->priceInfo = $this->getMock('Magento\Framework\Pricing\PriceInfo\Base', [], [], '', false);
        $this->priceInfo->expects($this->any())->method('getPrice')->will($this->returnValue($basePrice));

        $this->product = $this->getMockBuilder('Magento\Catalog\Model\Product')
            ->setMethods(['getPriceInfo', 'getOptionById', 'getResource', '__wakeup'])
            ->disableOriginalConstructor()
            ->getMock();
        $this->product->expects($this->once())->method('getPriceInfo')->will($this->returnValue($this->priceInfo));

        $this->item = $this->getMockBuilder('Magento\Catalog\Model\Product\Configuration\Item\ItemInterface')
            ->getMock();
        $this->item->expects($this->any())->method('getProduct')->will($this->returnValue($this->product));

        $this->calculator = $this->getMock('Magento\Framework\Pricing\Adjustment\Calculator', [], [], '', false);

        $this->model = new ConfiguredPrice($this->product, 1, $this->calculator);
        $this->model->setItem($this->item);
    }

    /**
     * Test of value getter
     */
    public function testOptionsValueGetter()
    {
        $optionCollection = $this->getMock('Magento\Catalog\Model\Product\Configuration\Item\Option\OptionInterface');
        $optionCollection->expects($this->any())->method('getValue')->will($this->returnValue('1,2,3'));

        $optionCallback = $this->returnCallback(function ($optionId) {
            return $this->createProductOptionStub($optionId);
        });
        $this->product->expects($this->any())->method('getOptionById')->will($optionCallback);

        $itemOption = $this->getMock('Magento\Catalog\Model\Product\Configuration\Item\Option\OptionInterface');
        $optionsList = [
            'option_1' => $itemOption,
            'option_2' => $itemOption,
            'option_3' => $itemOption,
            'option_ids' => $optionCollection
        ];
        $optionsGetterByCode = $this->returnCallback(function ($code) use ($optionsList) {
            return $optionsList[$code];
        });
        $this->item->expects($this->atLeastOnce())->method('getOptionByCode')->will($optionsGetterByCode);

        $this->assertEquals(830., $this->model->getValue());
    }

    /**
     * @param int $optionId
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function createProductOptionStub($optionId)
    {
        $option = $this->getMock('Magento\Catalog\Model\Product\Option', [], [], '', false);
        $option->expects($this->any())->method('getId')->will($this->returnValue($optionId));
        $option->expects($this->atLeastOnce())->method('groupFactory')->will(
            $this->returnValue($this->createOptionTypeStub($option))
        );
        return $option;
    }

    /**
     * @param \Magento\Catalog\Model\Product\Option $option
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function createOptionTypeStub(\Magento\Catalog\Model\Product\Option $option)
    {
        $optionType = $this->getMockBuilder('Magento\Catalog\Model\Product\Option\Type\DefaultType')
            ->setMethods(['setOption', 'setConfigurationItem', 'setConfigurationItemOption', 'getOptionPrice'])
            ->disableOriginalConstructor()
            ->getMock();
        $optionType->expects($this->atLeastOnce())->method('setOption')->with($option)->will($this->returnSelf());
        $optionType->expects($this->atLeastOnce())->method('setConfigurationItem')->will($this->returnSelf());
        $optionType->expects($this->atLeastOnce())->method('setConfigurationItemOption')->will($this->returnSelf());
        $optionType->expects($this->atLeastOnce())->method('getOptionPrice')
            ->with($this->anything(), $this->basePriceValue)
            ->will($this->returnValue(10.));
        return $optionType;
    }
}