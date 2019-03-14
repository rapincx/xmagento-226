define([
    'underscore',
    'Magento_Ui/js/grid/columns/select'
], function (_, Select) {
    'use strict';

    return Select.extend({
        defaults: {
            additionalCustomClass: '',
            customClasses: {
                pending: 'grid-severity-critical',
                read: 'grid-severity-minor',
                answered: 'grid-severity-notice'
            },
            bodyTmpl: 'ChaOS_AskQuestion/grid/cells/text'
        },

        /**
         *
         * @param {obj} row
         * @returns {str}
         */
        getCustomClass: function (row) {
            var customClass = this.customClasses[row.status] || '';
            return customClass;
        }
    });
});