<?php

/**
 * Page Preview Extension for Magento 2
 *
 * @author     Volodymyr Konstanchuk http://konstanchuk.com
 * @copyright  Copyright (c) 2017 The authors
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace Konstanchuk\PagePreview\Model\Preview;

use Magento\Framework\UrlInterface;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\Module\Manager as ModuleManager;


abstract class AbstractPage
{
    /** @var $_frontendUrlBuilder UrlInterface */
    protected $_frontendUrlBuilder;

    /** @var $_backendUrlBuilder UrlInterface */
    protected $_backendUrlBuilder;

    /** @var ObjectManagerInterface */
    protected $_objectManager;

    /** @var ModuleManager */
    protected $_moduleManager;

    public function __construct(UrlInterface $frontendUrlBuilder,
                                UrlInterface $backendUrlBuilder,
                                ObjectManagerInterface $objectManager,
                                ModuleManager $moduleManager)
    {
        $this->_frontendUrlBuilder = $frontendUrlBuilder;
        $this->_backendUrlBuilder = $backendUrlBuilder;
        $this->_objectManager = $objectManager;
        $this->_moduleManager = $moduleManager;
    }

    protected function _removeLanguageFromUrl($url)
    {
        try {
            if ($this->_moduleManager->isEnabled('Konstanchuk_LangInUrl')) {
                /** @var \Konstanchuk\LangInUrl\Helper\Data $langInUrlHelper */
                $langInUrlHelper = $this->_objectManager->get('Konstanchuk\LangInUrl\Helper\Data');
                if ($langInUrlHelper->isEnabled()) {
                    return $langInUrlHelper->removeLangFromUrl($url);
                }
            }
        } catch (\Exception $e) {}
        return $url;
    }

    abstract public function getTitle();

    abstract public function getAdminEditUrl(array $params);

    abstract public function getFrontendUrl(array $params);

    abstract public function getKey();

    abstract public function getFullActionName();
}