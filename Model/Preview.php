<?php

/**
 * Page Preview Extension for Magento 2
 *
 * @author     Volodymyr Konstanchuk http://konstanchuk.com
 * @copyright  Copyright (c) 2017 The authors
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace Konstanchuk\PagePreview\Model;

use Magento\Framework\ObjectManagerInterface;


class Preview
{
    /** @var array */
    protected $_pages = [];

    /** @var array */
    protected $_actionsToPages = [];

    /** @var array */
    protected $_keysToPages = [];

    /** @var ObjectManagerInterface */
    protected $_objectManager;

    public function __construct(ObjectManagerInterface $objectManager, array $pages = [])
    {
        $this->_objectManager = $objectManager;
        foreach ($pages as $page) {
            /** @var \Konstanchuk\PagePreview\Model\Preview\AbstractPage $item */
            if (is_string($page)) {
                $item = $objectManager->get($page);
            } else if (is_object($page)) {
                $item = $page;
            } else {
                continue;
            }
            $this->_pages[] = $item;
            $this->_actionsToPages[$item->getFullActionName()] = $item;
            $this->_keysToPages[$item->getKey()] = $item;
        }
    }

    public function getPages()
    {
        return $this->_pages;
    }

    public function getPageByKey($key)
    {
        return $this->_keysToPages[$key] ?? null;
    }

    public function getPageByFullActionName($name)
    {
        return $this->_actionsToPages[$name] ?? null;
    }
}