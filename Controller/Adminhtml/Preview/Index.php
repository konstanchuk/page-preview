<?php

/**
 * Page Preview Extension for Magento 2
 *
 * @author     Volodymyr Konstanchuk http://konstanchuk.com
 * @copyright  Copyright (c) 2017 The authors
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace Konstanchuk\PagePreview\Controller\Adminhtml\Preview;

use Magento\Framework\App\ResponseInterface;
use Magento\Backend\App\Action;
use Konstanchuk\PagePreview\Helper\Data as Helper;
use Konstanchuk\PagePreview\Model\Session as PagePreviewSession;
use Konstanchuk\PagePreview\Model\Preview as PreviewModel;


class Index extends Action
{
    /** @var  Helper */
    protected $_moduleHelper;

    /** @var  PagePreviewSession */
    protected $_pagePreviewSession;

    /** @var  PreviewModel */
    protected $_previewModel;

    public function __construct(Action\Context $context,
                                Helper $helper,
                                PreviewModel $previewModel,
                                PagePreviewSession $pagePreviewSession)
    {
        parent::__construct($context);
        $this->_moduleHelper = $helper;
        $this->_previewModel = $previewModel;
        $this->_pagePreviewSession = $pagePreviewSession;
    }

    /**
     * Dispatch request
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        $type = $this->getRequest()->getParam('type');
        $pageUrl = null;
        try {
            $page = $this->_previewModel->getPageByKey($type);
            if ($page) {
                $pageUrl = $page->getFrontendUrl($this->getRequest()->getParams());
            } else {
                throw new \Exception(__('invalid type param in request'));
            }
            $params = [
                Helper::RANDOM_PARAM => $this->_moduleHelper->generateRandomString(), //ignore fpc
            ];
            if ($pageUrl) {
                $key = $this->_pagePreviewSession->getKey();
                if (!$key) {
                    $key = $this->_moduleHelper->generateRandomString();
                    $this->_pagePreviewSession->setKey($key);
                }
                $params[Helper::PREVIEW_PAGE_PARAM] = $key;
                $pageUrl = $this->_moduleHelper->addParamsToUrl($pageUrl, $params);
            }
        } catch (\Exception $e) {
            $this->getMessageManager()->addErrorMessage($e->getMessage());
        }
        if (!$pageUrl) {
            $pageUrl = $this->getUrl('adminhtml/dashboard');
            $this->getMessageManager()->addErrorMessage(__('cannot find page for preview.'));
        }
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setUrl($pageUrl);
        return $resultRedirect;
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return true;
    }
}