<?php

/**
 * Page Preview Extension for Magento 2
 *
 * @author     Volodymyr Konstanchuk http://konstanchuk.com
 * @copyright  Copyright (c) 2017 The authors
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace Konstanchuk\PagePreview\Model\Cms\Model\ResourceModel;


class Page extends \Magento\Cms\Model\ResourceModel\Page
{
    protected function _getLoadSelect($field, $value, $object)
    {
        $select = parent::_getLoadSelect($field, $value, $object);
        $om = \Magento\Framework\App\ObjectManager::getInstance();
        /** @var \Konstanchuk\PagePreview\Helper\Data $helper */
        $helper = $om->get('Konstanchuk\PagePreview\Helper\Data');
        if ($helper->canPreview()) {
            $where = $select->getPart(\Zend_Db_Select::WHERE);
            foreach ($where as $index => $value) {
                if ($value == 'AND (is_active = 1)') {
                    unset($where[$index]);
                    $select->setPart(\Zend_Db_Select::WHERE, $where);
                    break;
                }
            }
        }
        return $select;
    }
}