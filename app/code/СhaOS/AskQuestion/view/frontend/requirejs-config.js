var config = {
    config: {
        mixins: {
            'mage/validation': {
                'ChaOS_AskQuestion/js/phone-ukr-mixin': true
            },
            'Magento_Ui/js/lib/validation/rules': {
                'ChaOS_AskQuestion/js/rule-mobile-ukrainian-ui-mixin': true
            }
        }
    },
    map: {
        '*': {
            askQuestion: 'ChaOS_AskQuestion/js/askQuestion'
        }
    }
};