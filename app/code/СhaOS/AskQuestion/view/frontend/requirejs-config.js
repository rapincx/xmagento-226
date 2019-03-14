var config = {
    'config': {
        'mixins': {
            'mage/validation': {
                'ChaOS_AskQuestion/js/phoneUkr': true
            },
            'Magento_Ui/js/lib/validation/rules': {
                'ChaOS_AskQuestion/js/rule-mobile-ukrainian-ui-mixin': true
            }
        }
    },
    map: {
        '*': {
            askquestion: 'ChaOS_AskQuestion/js/askQuestion'
        }
    }
};