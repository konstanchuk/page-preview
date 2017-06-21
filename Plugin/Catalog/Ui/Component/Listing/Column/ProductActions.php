<?php

/**
 * Page Preview Extension for Magento 2
 *
 * @author     Volodymyr Konstanchuk http://konstanchuk.com
 * @copyright  Copyright (c) 2017 The authors
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace Konstanchuk\PagePreview\Plugin\Catalog\Ui\Component\Listing\Column;

use Magento\Framework\UrlInterface;
use Konstanchuk\PagePreview\Model\Preview\ProductPage as Page;


class ProductActions
{
    /** @var UrlInterface */
    protected $urlBuilder;

    /** @var Page */
    protected $page;

    public function __construct(
        UrlInterface $urlBuilder,
        Page $page
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->page = $page;
    }

    public function afterPrepareDataSource($subject, $result)
    {
        if (isset($result['data']['items'])) {
            /** @var \Magento\Catalog\Ui\Component\Listing\Columns\ProductActions $subject */
            $name = $subject->getData('name');
            foreach ($result['data']['items'] as &$item) {
                $item[$name]['konstanchuk_page_preview'] = [
                    'href' => $this->urlBuilder->getUrl('konstanchuk_page_preview/preview/index', [
                        'type' => $this->page->getKey(),
                        'product_id' => $item['entity_id'],
                    ]),
                    'label' => __('Product Page Preview'),
                ];
            }
        }
        return $result;
    }
}