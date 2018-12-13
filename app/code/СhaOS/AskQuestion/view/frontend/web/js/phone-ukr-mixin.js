define([
    'jquery',
    'jquery/ui',
    'jquery/validate',
    'mage/translate'
], function ($) {
    'use strict';

    return function () {
        $.validator.addMethod(
            'mobileUKR',

            /**
             * @param {*|str} value
             * @param {*|obj} element
             * @returns {*|bool}
             */
            function (value, element) {
                return this.optional(element) || /^\+380\d{9}$/.test(value);
            },
            $.mage.__('Correct ukrainian mobile number without spaces please')
        );
    };
});