<?php

/**
 * Page Preview Extension for Magento 2
 *
 * @author     Volodymyr Konstanchuk http://konstanchuk.com
 * @copyright  Copyright (c) 2017 The authors
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace Konstanchuk\PagePreview\Observer;

use Magento\Framework\Event\ObserverInterface;
use Konstanchuk\PagePreview\Helper\Data as Helper;
use Magento\Framework\View\Layout;


class LoadLayout implements ObserverInterface
{
    /** @var Helper */
    protected $_helper;

    public function __construct(Helper $helper)
    {
        $this->_helper = $helper;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if (!$this->_helper->canPreview()) {
            return;
        }
        /** @var Layout $layout */
        $layout = $observer->getLayout();
        $layout->getUpdate()->addHandle('konstanchuk_page_preview');
    }
}