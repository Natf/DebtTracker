export default class DebtCreator {

    constructor() {
        this.form = $('form.dt-create-debt');
        this.pages = $('div.dt-create-debt__container');
        this.progressBar = $('.dt-create-debt__progress-bar');
        this.currentPage = 0;
    }

    init() {
        this.pages.not(this.pages.first()).hide();
        this.initProgress();
        this.updateProgress();
    }

    initProgress() {
        this.pages.each((index, element) => {
            let counter = $('<div class="dt-create-debt__counter">');
            let step = $('<div class="dt-create-debt__counter--step">');
            let text = $('<div class="dt-create-debt__counter--text">');
            step.text(index + 1);
            text.text($(element).attr('data-value'));
            counter.append(text, step);
            this.progressBar.append(counter);
        });
        this.counterTexts = $('.dt-create-debt__counter--text');
        this.counters = $('.dt-create-debt__counter');
        this.counterTexts.not(this.counterTexts.get(0)).hide();
    }
    
    updateProgress() {
        $(this.counters.slice(0, this.currentPage)).addClass('dt-create-debt__counter--complete');
        $(this.counters.get(this.currentPage)).addClass('dt-create-debt__counter--active');
        this.counters.not(this.counters.get(this.currentPage)).removeClass('dt-create-debt__counter--active');
        let visibleCounterTexts = this.counterTexts.filter(':visible');
        visibleCounterTexts.hide();
        $(visibleCounterTexts.get(this.currentPage)).animate({width: "toggle"}, 300);
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
}
