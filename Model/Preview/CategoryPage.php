<?php

/**
 * Page Preview Extension for Magento 2
 *
 * @author     Volodymyr Konstanchuk http://konstanchuk.com
 * @copyright  Copyright (c) 2017 The authors
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace Konstanchuk\PagePreview\Model\Preview;


class CategoryPage extends AbstractPage
{
    const KEY = 'category_page';

    public function getTitle()
    {
        return __('Category Page Preview');
    }

    public function getAdminEditUrl(array $params)
    {
        if (isset($params['id'])) {
            return $this->_removeLanguageFromUrl($this->_backendUrlBuilder->getUrl('catalog/category/edit', [
                'id' => $params['id'],
            ]));
        }
    }

    public function getFrontendUrl(array $params)
    {
        if (isset($params['category_id'])) {
            return $this->_frontendUrlBuilder->getUrl('catalog/category/view', [
                'id' => $params['category_id'],
            ]);
        }
    }

    public function getKey()
    {
        return self::KEY;
    }

    public function getFullActionName()
    {
        return 'catalog_category_view';
    }
}