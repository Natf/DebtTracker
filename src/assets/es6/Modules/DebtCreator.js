export default class DebtCreator {

    constructor() {
        this.form = $('form.dt-create-debt');
        this.pages = $('div.dt-create-debt__container');
        this.progressBar = $('.dt-create-debt__progress-bar');
        this.controls = $('div.dt-create-debt__controls')
        this.currentPage = 0;
        this.debtTypeAction = '';
    }

    init() {
        this.pages.not(this.pages.first()).hide();
        this.initProgress();
        this.updateProgress();
        this.initControls();
        this.initSplitControls();
        this.updateAll();
    }

    initProgress() {
        this.pages.each((index, page) => {
            let counter = $('<div class="dt-create-debt__counter">');
            let stepContainer = $('<div class="dt-create-debt__counter--step-container">');
            let step = $('<div class="dt-create-debt__counter--step">');
            let text = $('<div class="dt-create-debt__counter--text">');
            step.text(index + 1);
            stepContainer.append(step);
            text.text($(page).attr('data-value'));
            counter.append(stepContainer, text);
            this.progressBar.append(counter);
        });
        this.counters = $('.dt-create-debt__counter');
    }

    initControls() {
        this.buttons = {};
        $('.dt-create-debt__button').each((index, button) => {
            this.buttons[$(button).attr('data-value')] = $(button);
        });

        this.buttons['submit'].hide();
        this.buttons['back'].hide();

        this.buttons['cancel'].on('click', () => {
            window.location.href = "/debts/view";
        });

        this.buttons['back'].on('click', () => {
            this.currentPage--;
            this.updateAll();
        });

        this.buttons['next'].on('click', () => {
            this.currentPage++;
            this.updateAll();
        });

        this.buttons['submit'].on('click', () => {
            this.form.submit();
            this.updateAll();
        });
    }

    initSplitControls() {
        this.splitControls = $('div.dt-create-debt__split-content--container');
        this.splitControls.each((index, control) => {
            $(control).on('click', () => {
               this.currentPage++;
               this.updateAll();
               this.debtTypeAction = $(control).attr('action');
            });
        });
    }

    updateAll() {
        this.updateMenu();
        this.updateProgress();
        this.updatePage();
    }

    updateProgress() {
        $(this.counters.slice(0, this.currentPage)).addClass('dt-create-debt__counter--complete');
        $(this.counters.get(this.currentPage)).addClass('dt-create-debt__counter--active');
        this.counters.not(this.counters.get(this.currentPage)).removeClass('dt-create-debt__counter--active');
        // let visibleCounterTexts = this.counterTexts.filter(':visible');
        // visibleCounterTexts.hide();
        // $(visibleCounterTexts.get(this.currentPage)).animate({width: "toggle"}, 300);
    }

    updateMenu() {
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

    updatePage() {
        let currentPage = $(this.pages.get(this.currentPage));
        if (currentPage.attr('hide-controls') === "true") {
            this.controls.hide();
        } else {
            this.controls.show();
        }
        this.pages.not(this.pages.get(this.currentPage)).hide();
        currentPage.show();
    }
}
