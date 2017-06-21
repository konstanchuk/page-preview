<?php

/**
 * Page Preview Extension for Magento 2
 *
 * @author     Volodymyr Konstanchuk http://konstanchuk.com
 * @copyright  Copyright (c) 2017 The authors
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace Konstanchuk\PagePreview\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\Registry;
use Konstanchuk\PagePreview\Helper\Data as Helper;
use Konstanchuk\PagePreview\Model\Preview as PreviewModel;
use Magento\Framework\App\ResponseInterface;


class Info extends Template
{
    /** @var Helper */
    protected $_helper;

    /** @var Registry */
    protected $_registry;

    /** @var  PreviewModel */
    protected $_previewModel;

    /** @var  ResponseInterface */
    protected $_response;

    /** @var  \Konstanchuk\PagePreview\Model\Preview\AbstractPage */
    protected $_page;

    public function __construct(Template\Context $context,
                                Helper $helper,
                                Registry $registry,
                                PreviewModel $previewModel,
                                ResponseInterface $response,
                                array $data = [])
    {
        parent::__construct($context, $data);
        $this->_helper = $helper;
        $this->_registry = $registry;
        $this->_previewModel = $previewModel;
        $this->_response = $response;
    }

    public function getPage()
    {
        return $this->_previewModel->getPageByFullActionName($this->getRequest()->getFullActionName());
    }

    public function getAdminEditUrl()
    {
        $page = $this->getPage();
        return $page ? $page->getAdminEditUrl($this->getRequest()->getParams()) : null;
    }

    public function getResponseCode()
    {
        return $this->_response->getStatusCode();
    }

    protected function _toHtml()
    {
        if ($this->_helper->canPreview()) {
            return parent::_toHtml();
        }
    }
}