define([
    'jquery',
    'jquery/ui',
    'jquery/validate',
    'mage/translate'
], function ($) {
    'use strict';

    /**
     * Adding new rule
     */
    return function (rules) {
        rules['mobileUKR'] = {

            /**
             *
             * @param {*|str} value
             * @param {*|obj} element
             * @returns {*|bool}
             */
            handler: function (value, element) {
                return this.optional(element) || /^\+380\d{9}$/.test(value);
            },
            message: __('Address cannot be a PO Box address.')
        };
        return rules;
    };
});