<?php

/**
 * Page Preview Extension for Magento 2
 *
 * @author     Volodymyr Konstanchuk http://konstanchuk.com
 * @copyright  Copyright (c) 2017 The authors
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace Konstanchuk\PagePreview\Model\Preview;


class CmsPage extends AbstractPage
{
    const KEY = 'cms_page';

    public function getTitle()
    {
        return __('Cms Page Preview');
    }

    public function getAdminEditUrl(array $params)
    {
        if (isset($params['id'])) {
            return $this->_removeLanguageFromUrl($this->_backendUrlBuilder->getUrl('cms/page/edit', [
                'page_id' => $params['id'],
            ]));
        }
    }

    public function getFrontendUrl(array $params)
    {
        if (isset($params['page_id'])) {
            return $this->_frontendUrlBuilder->getUrl('cms/page/view', [
                'id' => $params['page_id'],
            ]);
        }
    }

    public function getKey()
    {
        return self::KEY;
    }

    public function getFullActionName()
    {
        return 'cms_page_view';
    }
}