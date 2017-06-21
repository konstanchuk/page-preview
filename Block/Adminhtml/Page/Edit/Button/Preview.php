<?php

/**
 * Page Preview Extension for Magento 2
 *
 * @author     Volodymyr Konstanchuk http://konstanchuk.com
 * @copyright  Copyright (c) 2017 The authors
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace Konstanchuk\PagePreview\Block\Adminhtml\Page\Edit\Button;

use Magento\Cms\Block\Adminhtml\Page\Edit\GenericButton;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;


class Preview extends GenericButton implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData()
    {
        $data = [
            'label' => __('Page Preview'),
            'class' => 'default',
            'on_click' => 'return false',
            'sort_order' => 100,
        ];
        if ($this->getPageId()) {
            $om = \Magento\Framework\App\ObjectManager::getInstance();
            /** @var \Konstanchuk\PagePreview\Model\Preview\CmsPage $page */
            $page = $om->get('Konstanchuk\PagePreview\Model\Preview\CmsPage');
            $data['data_attribute'] = [
                'mage-init' => [
                    'Konstanchuk_PagePreview/js/open-preview-page' => [
                        'title' => __('All unsaved will be lost.'),
                        'message' => __('All unsaved will be lost. If you do not want users to see this page, save it with the disabled status.'),
                        'postData' => [
                            'type' => $page->getKey(),
                            'page_id' => $this->getPageId(),
                        ],
                        'url' => $this->getUrl('konstanchuk_page_preview/preview/index'),
                    ],
                ],
            ];
        } else {
            $data['data_attribute'] = [
                'mage-init' => [
                    'Konstanchuk_PagePreview/js/open-preview-page' => [
                        'message' => __('To view this page as preview page, save it with status "disable".'),
                        'alert' => true,
                    ],
                ],
            ];
        }
        return $data;
    }
}
