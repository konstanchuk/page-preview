<?php

/**
 * Page Preview Extension for Magento 2
 *
 * @author     Volodymyr Konstanchuk http://konstanchuk.com
 * @copyright  Copyright (c) 2017 The authors
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace Konstanchuk\PagePreview\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Konstanchuk\PagePreview\Model\Session as PagePreviewSession;
use Magento\Framework\App\Helper\Context;


class Data extends AbstractHelper
{
    const PREVIEW_PAGE_PARAM = 'preview_page';
    const RANDOM_PARAM = 'random_param';

    /** @var  PagePreviewSession */
    protected $_pagePreviewSession;

    /** @var  bool */
    protected $_canPreview;

    public function __construct(Context $context,
                                PagePreviewSession $pagePreviewSession)
    {
        parent::__construct($context);
        $this->_pagePreviewSession = $pagePreviewSession;

        $urlKey = $this->_getRequest()->getParam(self::PREVIEW_PAGE_PARAM);
        $sessionKey = $pagePreviewSession->getKey();
        $this->_canPreview =  $urlKey && $sessionKey && $urlKey == $sessionKey;
    }

    public function canPreview()
    {
        return $this->_canPreview;
    }

    public function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; ++$i) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function addParamsToUrl($url, array $params)
    {
        $parsedUrl = is_array($url) ? $url : parse_url($url);
        $queryParams = array();
        if (isset($parsedUrl['query'])) {
            parse_str($parsedUrl['query'], $queryParams);
        }
        foreach ($params as $key => $value) {
            $queryParams[$key] = $value;
        }
        if (count($queryParams)) {
            $parsedUrl['query'] = http_build_query($queryParams);
        }
        return $this->unparseUrl($parsedUrl);
    }

    public function unparseUrl(array $parsedUrl)
    {
        $scheme = isset($parsedUrl['scheme']) ? $parsedUrl['scheme'] . '://' : '';
        $host = isset($parsedUrl['host']) ? $parsedUrl['host'] : '';
        $port = isset($parsedUrl['port']) ? ':' . $parsedUrl['port'] : '';
        $user = isset($parsedUrl['user']) ? $parsedUrl['user'] : '';
        $pass = isset($parsedUrl['pass']) ? ':' . $parsedUrl['pass'] : '';
        $pass = ($user || $pass) ? "$pass@" : '';
        $path = isset($parsedUrl['path']) ? $parsedUrl['path'] : '';
        $query = isset($parsedUrl['query']) ? '?' . $parsedUrl['query'] : '';
        $fragment = isset($parsedUrl['fragment']) ? '#' . $parsedUrl['fragment'] : '';
        return "$scheme$user$pass$host$port$path$query$fragment";
    }
}