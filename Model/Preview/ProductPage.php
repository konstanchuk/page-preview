<?php

/**
 * Page Preview Extension for Magento 2
 *
 * @author     Volodymyr Konstanchuk http://konstanchuk.com
 * @copyright  Copyright (c) 2017 The authors
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace Konstanchuk\PagePreview\Model\Preview;


class ProductPage extends AbstractPage
{
    const KEY = 'product_page';

    public function getTitle()
    {
        return __('Product Page Preview');
    }

    public function getAdminEditUrl(array $params)
    {
        if (isset($params['id'])) {
            return $this->_removeLanguageFromUrl($this->_backendUrlBuilder->getUrl('catalog/product/edit', [
                'id' => $params['id'],
            ]));
        }
    }

    public function getFrontendUrl(array $params)
    {
        if (isset($params['product_id'])) {
            return $this->_frontendUrlBuilder->getUrl('catalog/product/view', [
                'id' => $params['product_id'],
            ]);
        }
    }

    public function getKey()
    {
        return self::KEY;
    }

    public function getFullActionName()
    {
        return 'catalog_product_view';
    }
}