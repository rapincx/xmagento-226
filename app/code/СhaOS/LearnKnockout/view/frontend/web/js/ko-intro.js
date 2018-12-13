define(
    [
        'jquery',
        'uiComponent',
        'ko',
        'ChaOS_LearnKnockout/js/model/ko-intro-model'
    ],
    function (
        $,
        Component,
        ko,
        rgbModel
    ) {
        'use strict';

        var self;

        return Component.extend({
            cTimer: ko.observable(0),
            randomColor: ko.computed(function () {
                return 'rgb(' + rgbModel.red() + ', ' + rgbModel.blue() + ', ' + rgbModel.green() + ')';
            }, this),

            /**
             * {inheritdoc}
             */
            initialize: function () {
                self = this;

                this._super();
                this.incrementTime();
                this.subscribeToTime();
            },

            /**
             * Increments timer value
             */
            incrementTime: function () {
                var t = 0;

                setInterval(function () {
                    t++;
                    self.cTimer(t);
                }, 1000);
            },

            /**
             * Subscribe to model update
             */
            subscribeToTime: function () {
                this.cTimer.subscribe(function () {
                    rgbModel.updateColor();
                });
            }
        });
    }
);