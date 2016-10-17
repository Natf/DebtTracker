$(window).on('load', function() {
    var panels = $('.dt-add-debt-container');
    var currentSlide = 0;
    panels.not(panels.first()).hide();

    function updateMenuSize() {
        var buttons = $('.dt-add-debt-button:visible');

        $.each(buttons, function(index, element) {
            if(index > 0) {
                $(this).attr('style', 'width:' + (75/(buttons.length -1 )) + '%;');
            }
        });
    }

    function updateMenu() {
        updateProgress();
        if(currentSlide == 0) {
            $('.dt-add-debt-button[data-value="back"]').hide();
            $('.dt-add-debt-button[data-value="submit"]').hide();
        } else if(currentSlide == (panels.length - 1)){
            $('.dt-add-debt-button[data-value="next"]').hide();
            $('.dt-add-debt-button[data-value="submit"]').show();
        } else {
            $('.dt-add-debt-button[data-value="back"]').show();
            $('.dt-add-debt-button[data-value="next"]').show();
            $('.dt-add-debt-button[data-value="submit"]').hide();
        }

        updateMenuSize();
    }

    function updateProgress() {
        var counterTexts = $('.dt-add-debt-counter-text');
        $($('.dt-add-debt-counter').slice(0, currentSlide)).addClass('dt-add-debt-counter-complete')
        $($('.dt-add-debt-counter').get(currentSlide)).addClass('dt-add-debt-counter-active');
        $('.dt-add-debt-counter').not($('.dt-add-debt-counter').get(currentSlide)).removeClass('dt-add-debt-counter-active');
        var counters = counterTexts.filter(':visible');
        counters.hide();
        $(counterTexts.get(currentSlide)).animate({width: "toggle"}, 300);
    }

    function initProgress(){
        $.each($('.dt-add-debt-container'), function(index, element) {
            var counter = $('<div class="dt-add-debt-counter">');
            var step = $('<div class="dt-add-debt-counter-step">');
            var text = $('<div class="dt-add-debt-counter-text">');
            step.text(index + 1);
            text.text($(this).attr('data-value'))
            counter.append(text, step);
            $('.dt-add-debt-progress').append(counter);
        });
        $('.dt-add-debt-counter-text').not($('.dt-add-debt-counter-text').get(0)).hide();
        updateProgress();
    }

    updateMenu();
    initProgress();

    function displaySliderValue(slider, value) {
        slider.slider("option", "value", value.toFixed(2));
        slider.siblings('.dt-add-debt-slider-paid').val(value.toFixed(2));
    }

    function weightSliders(sliders, change) {
        if(change < 0) {
            $.each(sliders, function() {
                var value = (parseFloat($(this).slider( "option", "value" )) - (change/sliders.length));
                displaySliderValue($(this), value);
            })
        } else if (change > 0) {
            exit = false;
            $.each(sliders, function(index, element) {
                if (parseFloat($(this).slider( "option", "value" )) <= change) {
                    change -= parseFloat($(this).slider( "option", "value" ));
                    displaySliderValue($(this), 0);
                    sliders.splice(index, 1);
                    weightSliders(sliders, change);
                    exit = true;
                    return false;
                }
            })
            if(exit) {
                return false;
            }
            $.each(sliders, function(index, element) {
                var value = (parseFloat($(this).slider( "option", "value" )) - (change/sliders.length));
                displaySliderValue($(this), value);
            })
        }
    }

    function addSlidersForContacts() {
        $('.dt-add-debt-contact-selected').each(function() {
            var slider = $('<div class="dt-add-debt-input dt-add-debt-slider" data-value="' + $(this).attr('value') + '">');
            var label = $('<label>');
            label.text($(this).text() + ": £");
            var input = $('<div class="dt-add-debt-slider-input">');
            var inputPaid = $('<input class="dt-add-debt-slider-paid" name="paid">');
            slider.append(label, input, inputPaid);
            $($('.dt-add-debt-content').get(1)).append(slider);
        });
        $('.dt-add-debt-slider-input').slider({});
        $('.dt-add-debt-slider-input').slider({
            slide : function(e, ui) {
                var change = ui.value.toFixed(2) - parseFloat($(this).attr('value')).toFixed(2);
                $(this).attr('value', ui.value.toFixed(2));
                weightSliders($('.dt-add-debt-slider-input').not($(this)), change)
                $(this).siblings('input').val(ui.value.toFixed(2));
            },
            change: function(event, ui) {
                $(this).attr('value', ui.value.toFixed(2));
            }
        })
        var oldValue;
        $('.dt-add-debt-slider-paid').on('change', function(event) {
            var change = $(this).val() - oldValue;
            oldValue = $(this).val();
            var sibling = $(this).siblings('.dt-add-debt-slider-input');
            sibling.slider( "option", "value", $(this).val());
            weightSliders($('.dt-add-debt-slider-input').not(sibling), change)
        }).focus(function(){
            // Get the value when input gains focus
             oldValue = $(this).val();
        })

        $('.dt-add-debt-slider-input').slider( "disable" );

        $('.dt-add-debt-total-debt-amount').on('change', function() {
            if($(this).val() > 0) {
                $('.dt-add-debt-slider-input').siblings('.dt-add-debt-slider-paid').val(0.00);
                $('.dt-add-debt-slider-you').children('input').val($(this).val());
                $('.dt-add-debt-slider-input').slider( "enable" );
                $('.dt-add-debt-slider-input').slider({
                    max: $(this).val(),
                    step: 0.01
                });
                $($('.dt-add-debt-slider-input').get(0)).slider( "option", "value", $(this).val());
            }
        })
    }

    $('.dt-add-debt-contact').on('click', function() {
        $(this).toggleClass('dt-add-debt-contact-selected');
    });

    $('.dt-add-debt-button[data-value="next"]').on('click', function(){
        $(panels.get(currentSlide)).hide("slide", { direction: "left" }, 500, function() {
            currentSlide += 1;
            updateMenu();
            $(panels.get(currentSlide)).show("slide", { direction: "right" }, 500);
            if(currentSlide == 1) {
                addSlidersForContacts();
            }
        });
    });

    $('.dt-add-debt-button[data-value="back"]').on('click', function(){
        $(panels.get(currentSlide)).hide("slide", { direction: "right" }, 500, function() {
            currentSlide -= 1;
            updateMenu();
            $(panels.get(currentSlide)).show("slide", { direction: "left" }, 500);
        });
    });

    $('.dt-add-debt-button[data-value="submit"]').on('click', function() {
        var users = []
        $('.dt-add-debt-input.dt-add-debt-slider').each(function() {
            users.push(JSON.stringify({
                'user_id': $(this).attr('data-value'),
                'amount_paid': $(this).children('.dt-add-debt-slider-paid').val()
            }));
        });
        $.post("/debts/create",{
            debt_amount: $('.dt-add-debt-total-debt-amount').val(),
            description: $('.dt-add-debt-description').val(),
            'users[]' : users
        }).done( function( data ) {
            window.location.href = "/debts/view";
        });
    });

    $('.dt-add-debt-button[data-value="cancel"]').on('click', function() {
        window.location.href = "/debts/view";
    });
});