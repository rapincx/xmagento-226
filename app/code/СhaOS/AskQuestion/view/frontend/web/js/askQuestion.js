define([
    'jquery',
    'Magento_Ui/js/modal/alert',
    'mage/cookies',
    'mage/translate',
    'jquery/ui'
], function ($, alert) {
    'use strict';

    $.widget('chaos.askQuestion', {
        options: {
            cookieName: 'ask_question_stop_flooding',
            cookieLifeTime: 120,
            floodMessage: {
                title: 'Sorry, this form is currently not available',
                content: 'You can use this form after few minutes'
            }
        },

        /** @inheritdoc */
        _create: function () {
            $(this.element).submit(this.submitForm.bind(this));
        },

        /**
         * return void;
         */
        submitForm: function () {
            if (!this.validateForm() || this.isFlood()) {
                return;
            }

            this.ajaxSubmit();
        },

        /**
         *
         * @returns {*|jQuery}
         */
        validateForm: function () {
            return $(this.element).validation().valid();
        },

        /**
         * Submit request via AJAX. Add form key to the post data.
         */
        ajaxSubmit: function () {
            var formData = new FormData($(this.element).get(0));

            formData.append('form_key', $.mage.cookies.get('form_key'));
            formData.append('isAjax', 1);

            $.ajax({
                url: $(this.element).attr('action'),
                data: formData,
                processData: false,
                contentType: false,
                type: 'post',
                dataType: 'json',
                context: this,

                /** @inheritdoc */
                beforeSend: function () {
                    $('body').trigger('processStart');
                },

                /** @inheritdoc */
                success: function (response) {
                    var alertContent = response.message.name +
                        '! We got Your question and we will send answer to your e-mail: ' +
                        response.message.email;
                    $('body').trigger('processStop');

                    alert({
                        title: $.mage.__(response.status),
                        content: alertContent
                    });

                    if (response.status === 'Success') {
                        // Prevent from sending requests too often
                        $.mage.cookies.set(
                            this.options.cookieName,
                            true,
                            {
                                lifetime: this.options.cookieLifeTime
                            }
                        );
                    }
                },

                /** @inheritdoc */
                error: function () {
                    $('body').trigger('processStop');
                    console.log('err');
                    alert({
                        title: $.mage.__('Error'),
                        /*eslint max-len: ["error", { "ignoreStrings": true }]*/
                        content: $.mage.__('Your request can not be submitted right now. Please, contact us directly via email or phone to get your Sample.')
                    });
                }
            });
        },

        /**
         *
         * @returns {Boolean}
         */
        isFlood: function () {
            if ($.mage.cookies.get(this.options.cookieName)) {
                alert(this.options.floodMessage);
            }

            return $.mage.cookies.get(this.options.cookieName);
        }
    });

    return $.chaos.askQuestion;
});