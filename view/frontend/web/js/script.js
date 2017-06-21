/**
 * Page Preview Extension for Magento 2
 *
 * @author     Volodymyr Konstanchuk http://konstanchuk.com
 * @copyright  Copyright (c) 2017 The authors
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 */
define([
    'jquery',
    'underscore',
    'Magento_Ui/js/modal/alert'
], function ($, _, alertPopup) {
    'use strict';

    function generateRandomString(length) {
        if (!length) {
            length = 10;
        }
        var text = '';
        var possible = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        for (var i = 0; i < length; ++i) {
            text += possible.charAt(Math.floor(Math.random() * possible.length));
        }
        return text;
    }

    function setParamsToUrl(params, url) {
        if (!url) {
            url = window.location;
        }
        var parser = document.createElement('a');
        parser.href = url;
        var uri = parser.search;
        $.each(params, function (key, value) {
            key = encodeURI(key);
            var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i"),
                separator = uri.indexOf('?') !== -1 ? "&" : "?";
            if (uri.match(re)) {
                if (value !== null && value !== undefined) {
                    uri = uri.replace(re, '$1' + key + '=' + encodeURI(value) + '$2');
                } else {
                    uri = uri.replace(re, '$1');
                }
            } else {
                if (value !== null && value !== undefined) {
                    uri += separator + key + '=' + encodeURI(value);
                }
            }
            if (uri.length) {
                var lastCharacter = uri.slice(-1);
                if (lastCharacter == '?' || lastCharacter == '&') {
                    uri = uri.slice(0, -1);
                }
            }
        });
        parser.search = uri;
        return parser;
    }

    return function (config) {
        config = $.extend({
            'element': '.konstanchuk-page-preview',
            'response_code': 200,
            'random_param': 'random_param'
        }, config);
        if (config.response_code == 200) {
            var body = $('body'),
                element = $(config.element);
            body.addClass('konstanchuk-page-preview-body');
            element.find('.page-preview-close').on('click', function (e) {
                e.preventDefault();
                element.slideUp('slow');
                body.removeClass('konstanchuk-page-preview-body');
            });
        } else {
            var messages = {
                404: $.mage.__('Page was not found. This error can occur if the page is available in current store view. Try changing store view using dropdown store view.')
            };
            var message = _.has(messages, config.response_code)
                ? messages[config.response_code]
                : $.mage.__('It was discovered that the server returned %1 status.').replace('%1', config.response_code);
            alertPopup({
                content: message,
                actions: {
                    always: function () {
                    }
                }
            });
        }
        if (window.history) {
            // ignore FPC
            var params = {};
            params[config.random_param] = generateRandomString();
            window.history.pushState('', $(document).find('title').text(), setParamsToUrl(params));
        }
    };
});
