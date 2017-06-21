/**
 * Page Preview Extension for Magento 2
 *
 * @author     Volodymyr Konstanchuk http://konstanchuk.com
 * @copyright  Copyright (c) 2017 The authors
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 */
define([
    'jquery',
    'Magento_Ui/js/modal/confirm',
    'Magento_Ui/js/modal/alert',
    'mage/dataPost'
], function ($, confirmPopup, alertPopup, dataPost) {
    'use strict';

    return function (config, element) {
        $(element).on('click', function (e) {
            e.preventDefault();
            if (config.alert) {
                alertPopup({
                    title: config.title,
                    content: config.message,
                    actions: {
                        always: function () {
                        }
                    }
                });
            } else {
                confirmPopup({
                    title: config.title,
                    content: config.message,
                    actions: {
                        confirm: function () {
                            dataPost().postData({
                                data: config.postData,
                                action: config.url
                            });
                        }
                    },
                    buttons: [{
                        text: $.mage.__('Cancel'),
                        class: 'action-secondary action-dismiss',
                        click: function (event) {
                            this.closeModal(event);
                        }
                    }, {
                        text: $.mage.__('Go to page'),
                        class: 'action-primary action-accept',
                        click: function (event) {
                            this.closeModal(event, true);
                        }
                    }]
                });
            }
        });
    };
});
