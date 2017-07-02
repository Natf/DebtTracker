
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