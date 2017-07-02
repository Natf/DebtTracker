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
        this.controls = $('div.dt-create-debt__controls');
        this.currentPage = 0;
        this.debtTypeAction = '';
    }

    _createClass(DebtCreator, [{
        key: 'init',
        value: function init() {
            this.pages.not(this.pages.first()).hide();
            this.initProgress();
            this.updateProgress();
            this.initControls();
            this.initSplitControls();
            this.updateAll();
        }
    }, {
        key: 'initProgress',
        value: function initProgress() {
            var _this = this;

            this.pages.each(function (index, page) {
                var counter = $('<div class="dt-create-debt__counter">');
                var stepContainer = $('<div class="dt-create-debt__counter--step-container">');
                var step = $('<div class="dt-create-debt__counter--step">');
                var text = $('<div class="dt-create-debt__counter--text">');
                step.text(index + 1);
                stepContainer.append(step);
                text.text($(page).attr('data-value'));
                counter.append(stepContainer, text);
                _this.progressBar.append(counter);
            });
            this.counters = $('.dt-create-debt__counter');
        }
    }, {
        key: 'initControls',
        value: function initControls() {
            var _this2 = this;

            this.buttons = {};
            $('.dt-create-debt__button').each(function (index, button) {
                _this2.buttons[$(button).attr('data-value')] = $(button);
            });

            this.buttons['submit'].hide();
            this.buttons['back'].hide();

            this.buttons['cancel'].on('click', function () {
                window.location.href = "/debts/view";
            });

            this.buttons['back'].on('click', function () {
                _this2.currentPage--;
                _this2.updateAll();
            });

            this.buttons['next'].on('click', function () {
                _this2.currentPage++;
                _this2.updateAll();
            });

            this.buttons['submit'].on('click', function () {
                _this2.form.submit();
                _this2.updateAll();
            });
        }
    }, {
        key: 'initSplitControls',
        value: function initSplitControls() {
            var _this3 = this;

            this.splitControls = $('div.dt-create-debt__split-content--container');
            this.splitControls.each(function (index, control) {
                $(control).on('click', function () {
                    _this3.currentPage++;
                    _this3.updateAll();
                    _this3.debtTypeAction = $(control).attr('action');
                });
            });
        }
    }, {
        key: 'updateAll',
        value: function updateAll() {
            this.updateMenu();
            this.updateProgress();
            this.updatePage();
        }
    }, {
        key: 'updateProgress',
        value: function updateProgress() {
            $(this.counters.slice(0, this.currentPage)).addClass('dt-create-debt__counter--complete');
            $(this.counters.get(this.currentPage)).addClass('dt-create-debt__counter--active');
            this.counters.not(this.counters.get(this.currentPage)).removeClass('dt-create-debt__counter--active');
            // let visibleCounterTexts = this.counterTexts.filter(':visible');
            // visibleCounterTexts.hide();
            // $(visibleCounterTexts.get(this.currentPage)).animate({width: "toggle"}, 300);
        }
    }, {
        key: 'updateMenu',
        value: function updateMenu() {
            if (this.currentPage === this.pages.length - 1) {
                this.buttons['submit'].show();
                this.buttons['next'].hide();
            } else if (this.currentPage > 0) {
                this.buttons['submit'].hide();
                this.buttons['next'].show();
                this.buttons['back'].show();
            } else if (this.currentPage === 0) {
                this.buttons['back'].hide();
            }
        }
    }, {
        key: 'updatePage',
        value: function updatePage() {
            var currentPage = $(this.pages.get(this.currentPage));
            if (currentPage.attr('hide-controls') === "true") {
                this.controls.hide();
            } else {
                this.controls.show();
            }
            this.pages.not(this.pages.get(this.currentPage)).hide();
            currentPage.show();
        }
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
    var allModules = {
        "DebtCreator": _DebtCreator2.default
    };

    var modules = $('script[type="module"]');
    modules.each(function (index, module) {
        var moduleName = $(module).attr('module-name');
        var moduleLoaded = new allModules[moduleName]();
        moduleLoaded.init();
    });
};

},{"./Modules/DebtCreator.js":1}]},{},[2]);
