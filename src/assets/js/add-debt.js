$(window).on('load', function() {
    var panels = $('.dt-add-debt-container');
    var currentSlide = 0;
    panels.not(panels.first()).hide();

    function updateMenuSize() {
        var buttons = $('.dt-add-debt-button:visible');

        $.each(buttons, function(index, element) {
            if(index > 0) {
                $(this).attr('style', 'width:' + (100/(buttons.length -1 )) + '%;');
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
        $(counterTexts.get(currentSlide)).show();
        counterTexts.not(counterTexts.get(currentSlide)).hide();
    }

    function initProgress(){
        $.each($('.dt-add-debt-container'), function(index, element) {
            var counter = $('<div class="dt-add-debt-counter">');
            var step = $('<div class="dt-add-debt-counter-step">');
            var text = $('<div class="dt-add-debt-counter-text">');
            step.text(index + 1);
            text.text($(this).attr('data-value'))
            counter.append(step, text);
            $('.dt-add-debt-progress').append(counter);
        });
        $('.dt-add-debt-counter-text').hide();
        updateProgress();
    }

    updateMenu();
    initProgress();

    function displaySliderValue(slider, value) {
        slider.slider("option", "value", value);
        slider.siblings('.dt-add-debt-slider-paid').val(value);
    }

    function weightSliders(sliders, change) {
        console.log(change);
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
            console.log('slider length ' + sliders.length);
            $.each(sliders, function(index, element) {
                var value = (parseFloat($(this).slider( "option", "value" )) - (change/sliders.length));
                displaySliderValue($(this), value);
            })
        }
    }

    function addSlidersForContacts() {
        $('.dt-add-debt-contact-selected').each(function() {
            var slider = $('<div class="dt-add-debt-input dt-add-debt-slider">');
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
                console.log(change);
                weightSliders($('.dt-add-debt-slider-input').not($(this)), change)
                $(this).siblings('input').val(ui.value.toFixed(2));
            },
            change: function(event, ui) {
                $(this).attr('value', ui.value.toFixed(2));
            }
        })
        $('.dt-add-debt-slider-paid').on('change', function() {
            $(this).siblings('.dt-add-debt-slider-input').slider( "option", "value", $(this).val());
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
        $('.dt-add-debt-contact.dt-add-debt-contact-selected').each(function() {
            users += [
                'user_id' => $(this).val(),

            ];
        });
        $.post("/debts/create",{
            debt_amount: $('.dt-add-debt-total-debt-amount').val(),
            description: $('.dt-add-debt-description').val(),
            'users[]' : [
                'userId' => ,
            <div class="dt-add-debt-contact" value="<?= $contact['id'] ?>">
            ]
        }).done( function( data ) {
            window.location.href = "/debts/view";
        });
    });
});