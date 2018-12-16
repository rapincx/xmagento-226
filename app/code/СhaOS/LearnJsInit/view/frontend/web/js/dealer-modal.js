define(['jquery', 'Magento_Ui/js/modal/modal'], function ($, modal) {
    var options = {
        type: 'popup',
        responsive: true,
        innerScroll: true,
        title: '',
        buttons: [{
            text: $.mage.__('Close'),
            class: '',
            click: function () {
                this.closeModal();
            }
        }]
    };
    var popup = modal(options, $('.registration-dealer-form-box'));
    $('.registration-dealer-button').on('click', function () {
        popup.openModal().trigger('contentUpdated');
    });
});