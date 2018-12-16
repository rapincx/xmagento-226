define([
    'jquery',
    'jquery/ui',
], function ($) {
    'use strict';
    $.widget('chaos.askQuestion', {
        options: {
            action: ''
        },

        /** @inheritdoc */
        _create: function () {
            $(this.element).submit(this.submitForm.bind(this));
        },

        /**
         * return void;
         */
        submitForm: function () {
            if (!this.validateForm()) {
                return;
            }
            alert('Submition');
        },

        /**
         * return bool;
         */
        validateForm: function () {
            return $(this.element).validation().valid();
        }
    });

    return $.chaos.askQuestion;
});