<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Tools\I18n\Pack;

use Magento\Tools\I18n\Dictionary;
use Magento\Tools\I18n\Locale;

/**
 * Pack writer interface
 */
interface WriterInterface
{
    /**#@+
     * Save pack modes
     */
    const MODE_REPLACE = 'replace';

    const MODE_MERGE = 'merge';

    /**#@-*/

    /**
     * Write dictionary data to language pack
     *
     * @param \Magento\Tools\I18n\Dictionary $dictionary
     * @param string $packPath
     * @param \Magento\Tools\I18n\Locale $locale
     * @param string $mode One of const of WriterInterface::MODE_
     * @return void
     */
    public function write(Dictionary $dictionary, $packPath, Locale $locale, $mode);
}
