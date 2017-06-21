<?php

/**
 * Page Preview Extension for Magento 2
 *
 * @author     Volodymyr Konstanchuk http://konstanchuk.com
 * @copyright  Copyright (c) 2017 The authors
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace Konstanchuk\PagePreview\Model\Session;


class Storage extends \Magento\Framework\Session\Storage
{
    /**
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param string $namespace
     * @param array $data
     */
    public function __construct(
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        $namespace = \Konstanchuk\PagePreview\Model\Session::NAME,
        array $data = []
    ) {
        parent::__construct($namespace, $data);
    }
}
