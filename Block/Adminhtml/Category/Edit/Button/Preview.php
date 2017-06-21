<?php

/**
 * Page Preview Extension for Magento 2
 *
 * @author     Volodymyr Konstanchuk http://konstanchuk.com
 * @copyright  Copyright (c) 2017 The authors
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace Konstanchuk\PagePreview\Block\Adminhtml\Category\Edit\Button;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Magento\Catalog\Block\Adminhtml\Category\AbstractCategory;


class Preview extends AbstractCategory implements ButtonProviderInterface
{
    public function getButtonData()
    {
        $data = [
            'label' => __('Category Page Preview'),
            'class' => 'default',
            'on_click' => 'return false',
            'sort_order' => 10,
        ];
        if ($this->getCategory() && $this->getCategoryId()) {
            $om = \Magento\Framework\App\ObjectManager::getInstance();
            /** @var \Konstanchuk\PagePreview\Model\Preview\CategoryPage $page */
            $page = $om->get('Konstanchuk\PagePreview\Model\Preview\CategoryPage');
            $data['data_attribute'] = [
                'mage-init' => [
                    'Konstanchuk_PagePreview/js/open-preview-page' => [
                        'title' => __('All unsaved will be lost.'),
                        'message' => __('All unsaved will be lost. If you do not want users to see this сategory, save it with the disabled status.'),
                        'postData' => [
                            'type' => $page->getKey(),
                            'category_id' => $this->getCategoryId(),
                        ],
                        'url' => $this->getUrl('konstanchuk_page_preview/preview/index'),
                    ],
                ],
            ];
        } else {
            $data['data_attribute'] = [
                'mage-init' => [
                    'Konstanchuk_PagePreview/js/open-preview-page' => [
                        'message' => __('To view this category page as category preview page, save it with status "disable".'),
                        'alert' => true,
                    ],
                ],
            ];
        }
        return $data;
    }
}
