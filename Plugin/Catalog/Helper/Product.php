<?php

/**
 * Page Preview Extension for Magento 2
 *
 * @author     Volodymyr Konstanchuk http://konstanchuk.com
 * @copyright  Copyright (c) 2017 The authors
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace Konstanchuk\PagePreview\Plugin\Catalog\Helper;

use Magento\Catalog\Helper\Product as Subject;


class Product
{
    /** @var \Konstanchuk\PagePreview\Helper\Data */
    protected $_helper;

    public function __construct(\Konstanchuk\PagePreview\Helper\Data $helper)
    {
        $this->_helper = $helper;
    }

    public function afterCanShow(Subject $subject, $result)
    {
        if ($this->_helper->canPreview()) {
            return true;
        }
        return $result;
    }
}