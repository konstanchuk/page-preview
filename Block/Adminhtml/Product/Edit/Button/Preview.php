<?php

/**
 * Page Preview Extension for Magento 2
 *
 * @author     Volodymyr Konstanchuk http://konstanchuk.com
 * @copyright  Copyright (c) 2017 The authors
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace Konstanchuk\PagePreview\Block\Adminhtml\Product\Edit\Button;


class Preview extends \Magento\Catalog\Block\Adminhtml\Product\Edit\Button\Generic
{
    public function getButtonData()
    {
        $data = [
            'label' => __('Product Page Preview'),
            'class' => 'default',
            'on_click' => 'return false',
            'sort_order' => -1,
        ];
        if ($this->getProduct() && $this->getProduct()->getId()) {
            $om = \Magento\Framework\App\ObjectManager::getInstance();
            /** @var \Konstanchuk\PagePreview\Model\Preview\ProductPage $page */
            $page = $om->get('Konstanchuk\PagePreview\Model\Preview\ProductPage');
            $data['data_attribute'] = [
                'mage-init' => [
                    'Konstanchuk_PagePreview/js/open-preview-page' => [
                        'title' => __('All unsaved will be lost.'),
                        'message' => __('All unsaved will be lost. If you do not want users to see this product, save it with the disabled status.'),
                        'postData' => [
                            'type' => $page->getKey(),
                            'product_id' => $this->getProduct()->getId(),
                        ],
                        'url' => $this->getUrl('konstanchuk_page_preview/preview/index'),
                    ],
                ],
            ];
        } else {
            $data['data_attribute'] = [
                'mage-init' => [
                    'Konstanchuk_PagePreview/js/open-preview-page' => [
                        'message' => __('To view this product page as product preview page, save it with status "disable".'),
                        'alert' => true,
                    ],
                ],
            ];
        }
        return $data;
    }
}
