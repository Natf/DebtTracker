(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, "__esModule", {
    value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var DebtCreator = function () {
    function DebtCreator() {
        _classCallCheck(this, DebtCreator);

        this.form = $('form.dt-create-debt');
        this.pages = $('div.dt-create-debt__container');
        this.progressBar = $('.dt-create-debt__progress-bar');
        this.currentPage = 0;
    }

    _createClass(DebtCreator, [{
        key: 'init',
        value: function init() {
            this.pages.not(this.pages.first()).hide();
            this.initProgress();
            this.updateProgress();
        }
    }, {
        key: 'initProgress',
        value: function initProgress() {
            var _this = this;

            this.pages.each(function (index, element) {
                var counter = $('<div class="dt-create-debt__counter">');
                var step = $('<div class="dt-create-debt__counter--step">');
                var text = $('<div class="dt-create-debt__counter--text">');
                step.text(index + 1);
                text.text($(element).attr('data-value'));
                counter.append(text, step);
                _this.progressBar.append(counter);
            });
            this.counterTexts = $('.dt-create-debt__counter--text');
            this.counters = $('.dt-create-debt__counter');
            this.counterTexts.not(this.counterTexts.get(0)).hide();
        }
    }, {
        key: 'updateProgress',
        value: function updateProgress() {
            $(this.counters.slice(0, this.currentPage)).addClass('dt-create-debt__counter--complete');
            $(this.counters.get(this.currentPage)).addClass('dt-create-debt__counter--active');
            this.counters.not(this.counters.get(this.currentPage)).removeClass('dt-create-debt__counter--active');
            var visibleCounterTexts = this.counterTexts.filter(':visible');
            visibleCounterTexts.hide();
            $(visibleCounterTexts.get(this.currentPage)).animate({ width: "toggle" }, 300);
        }

        //     function updateMenuSize() {
        //
        //         var buttons = $('.dt-create-debt-button:visible');
        //         $.each(buttons, function(index, element) {
        //                 if(index > 0) {
        //                     $(this).attr('style', 'width:' + (75/(buttons.length -1 )) + '%;');
        //                 }
        //             });
        //     }
        //
        //     function updateMenu() {
        //         updateProgress();
        //         if(currentSlide == 0) {
        //             $('.dt-create-debt-button[data-value="back"]').hide();
        //             $('.dt-create-debt-button[data-value="submit"]').hide();
        //         } else if(currentSlide == (panels.length - 1)){
        //             $('.dt-create-debt-button[data-value="next"]').hide();
        //             $('.dt-create-debt-button[data-value="submit"]').show();
        //         } else {
        //             $('.dt-create-debt-button[data-value="back"]').show();
        //             $('.dt-create-debt-button[data-value="next"]').show();
        //             $('.dt-create-debt-button[data-value="submit"]').hide();
        //         }
        //
        //         updateMenuSize();
        //     }
        //
        //     updateMenu();
        //
        //         initProgress();
        //     function displaySliderValue(slider, value) {
        //         slider.slider("option", "value", value.toFixed(2));
        //         slider.siblings('.dt-create-debt-slider-paid').val(value.toFixed(2));
        //     }
        //
        //     function weightSliders(sliders, change) {
        //         if(change < 0) {
        //                 $.each(sliders, function() {
        //                     var value = (parseFloat($(this).slider( "option", "value" )) - (change/sliders.length));
        //                     displaySliderValue($(this), value);
        //                 })
        //             } else if (change > 0) {
        //                 exit = false;
        //                 $.each(sliders, function(index, element) {
        //                     if (parseFloat($(this).slider( "option", "value" )) <= change) {
        //                         change -= parseFloat($(this).slider( "option", "value" ));
        //                         displaySliderValue($(this), 0);
        //                         sliders.splice(index, 1);
        //                         weightSliders(sliders, change);
        //                         exit = true;
        //                         return false;
        //                     }
        //                 })
        //                 if(exit) {
        //                     return false;
        //                 }
        //                 $.each(sliders, function(index, element) {
        //                     var value = (parseFloat($(this).slider( "option", "value" )) - (change/sliders.length));
        //                     displaySliderValue($(this), value);
        //                 })
        //             }
        //     }
        //
        //     function addSlidersForContacts() {
        //         $('.dt-create-debt-contact-selected').each(function() {
        //                 var slider = $('<div class="dt-create-debt-input dt-create-debt-slider" data-value="' + $(this).attr('value') + '">');
        //                 var label = $('<label>');
        //                 label.text($(this).text() + ": £");
        //                 var input = $('<div class="dt-create-debt-slider-input">');
        //                 var inputPaid = $('<input class="dt-create-debt-slider-paid" name="paid">');
        //                 slider.append(label, input, inputPaid);
        //                 $($('.dt-create-debt-content').get(1)).append(slider);
        //             });
        //         $('.dt-create-debt-slider-input').slider({});
        //         $('.dt-create-debt-slider-input').slider({
        //                 slide : function(e, ui) {
        //                     var change = ui.value.toFixed(2) - parseFloat($(this).attr('value')).toFixed(2);
        //                     $(this).attr('value', ui.value.toFixed(2));
        //                     weightSliders($('.dt-create-debt-slider-input').not($(this)), change)
        //                     $(this).siblings('input').val(ui.value.toFixed(2));
        //                 },
        //                 change: function(event, ui) {
        //                     $(this).attr('value', ui.value.toFixed(2));
        //                 }
        //             })
        //         var oldValue;
        //
        //             $('.dt-create-debt-slider-paid').on('change', function(event) {
        //                 var change = $(this).val() - oldValue;
        //                 oldValue = $(this).val();
        //                 var sibling = $(this).siblings('.dt-create-debt-slider-input');
        //                 sibling.slider( "option", "value", $(this).val());
        //                 weightSliders($('.dt-create-debt-slider-input').not(sibling), change)
        //             }).focus(function(){
        //                 // Get the value when input gains focus
        //                 oldValue = $(this).val();
        //             })
        //
        //             $('.dt-create-debt-slider-input').slider( "disable" );
        //         $('.dt-create-debt-total-debt-amount').on('change', function() {
        //                 if($(this).val() > 0) {
        //                     $('.dt-create-debt-slider-input').siblings('.dt-create-debt-slider-paid').val(0.00);
        //                     $('.dt-create-debt-slider-you').children('input').val($(this).val());
        //                     $('.dt-create-debt-slider-input').slider( "enable" );
        //                     $('.dt-create-debt-slider-input').slider({
        //                         max: $(this).val(),
        //                         step: 0.01
        //                     });
        //                     $($('.dt-create-debt-slider-input').get(0)).slider( "option", "value", $(this).val());
        //                 }
        //             })
        //     }
        //
        //     $('.dt-create-debt-contact').on('click', function() {
        //         $(this).toggleClass('dt-create-debt-contact-selected');
        //
        //         });
        //     $('.dt-create-debt-button[data-value="next"]').on('click', function(){
        //         $(panels.get(currentSlide)).hide("slide", { direction: "left" }, 500, function() {
        //                 currentSlide += 1;
        //                 updateMenu();
        //                 $(panels.get(currentSlide)).show("slide", { direction: "right" }, 500);
        //                 if(currentSlide == 1) {
        //                     addSlidersForContacts();
        //                 }
        //             });
        //
        //         });
        //     $('.dt-create-debt-button[data-value="back"]').on('click', function(){
        //         $(panels.get(currentSlide)).hide("slide", { direction: "right" }, 500, function() {
        //                 currentSlide -= 1;
        //                 updateMenu();
        //                 $(panels.get(currentSlide)).show("slide", { direction: "left" }, 500);
        //             });
        //
        //         });
        //     $('.dt-create-debt-button[data-value="submit"]').on('click', function() {
        //         var users = []
        //         $('.dt-create-debt-input.dt-create-debt-slider').each(function() {
        //                 users.push(JSON.stringify({
        //                     'user_id': $(this).attr('data-value'),
        //                     'amount_paid': $(this).children('.dt-create-debt-slider-paid').val()
        //                 }));
        //             });
        //         $.post("/debts/create",{
        //                 debt_amount: $('.dt-create-debt-total-debt-amount').val(),
        //                 description: $('.dt-create-debt-description').val(),
        //                 'users[]' : users
        //             }).done( function( data ) {
        //                 window.location.href = "/debts/view";
        //             });
        //
        //         });
        //     $('.dt-create-debt-button[data-value="cancel"]').on('click', function() {
        //             window.location.href = "/debts/view";
        //         });
        // });

    }]);

    return DebtCreator;
}();

exports.default = DebtCreator;

},{}],2:[function(require,module,exports){
'use strict';

var _DebtCreator = require('./Modules/DebtCreator.js');

var _DebtCreator2 = _interopRequireDefault(_DebtCreator);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

window.onload = function () {
    var debtCreator = new _DebtCreator2.default();
    debtCreator.init();
    console.log('es5');
};

},{"./Modules/DebtCreator.js":1}]},{},[2]);
