<?php

/**
 * Page Preview Extension for Magento 2
 *
 * @author     Volodymyr Konstanchuk http://konstanchuk.com
 * @copyright  Copyright (c) 2017 The authors
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace Konstanchuk\PagePreview\Plugin\Cms\Ui\Component\Listing\Column;

use Magento\Framework\UrlInterface;
use Konstanchuk\PagePreview\Model\Preview as PreviewModel;
use Konstanchuk\PagePreview\Model\Preview\CmsPage as Page;


class PageActions
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
            foreach ($result['data']['items'] as &$item) {
                /** @var \Magento\Cms\Ui\Component\Listing\Column\PageActions $subject */
                $name = $subject->getData('name');
                if (isset($item['page_id'])) {
                    $item[$name]['konstanchuk_page_preview'] = [
                        'href' => $this->urlBuilder->getUrl('konstanchuk_page_preview/preview/index', [
                            'type' => $this->page->getKey(),
                            'page_id' => $item['page_id'],
                        ]),
                        'label' => __('Page Preview'),
                    ];
                }
            }
        }
        return $result;
    }
}