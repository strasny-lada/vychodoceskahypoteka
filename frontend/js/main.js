import svg4everybody from 'svg4everybody';
import $ from 'jquery';
import slick from 'slick';
import noUiSlider from 'slider';


window.$ = window.jQuery = $;


$(document).ready(() => {
    svg4everybody();

    var cache = {};

    $('.logo').on('click', function(evt) {
        evt.preventDefault();
    });

    $('.tabs__header__item__link').on('click', function(evt) {
        evt.preventDefault();

        var $this = $(this);

        //$('.tab--active').removeClass('tab--active');
        $('.tabs__header__item--active').removeClass('tabs__header__item--active');

        //$($this.attr('href')).addClass('tab--active');
        $this.closest('.tabs__header__item').addClass('tabs__header__item--active');

        if($this.attr('href').indexOf('1') > -1) {
            $('#lead_type').val($('#lead_type').data('value-buy'));
        } else {
            $('#lead_type').val($('#lead_type').data('value-refinance'));
        }
    });

    window.noUiSlider = noUiSlider;

    var moneyValue = document.getElementById('moneyValue');

    noUiSlider.create(moneyValue, {
        range: {
            'min': 350000,
            'max': 3000000
        },
        //snap: true,
        start: 400000,
        step: 50000
    });

    moneyValue.noUiSlider.on('update', function() {

        if(!$('.noUi-handle-lower span').length) {
            $('.noUi-handle-lower').append('<span class="slider-value"></span>');
        }

        var moneyValueNumber = parseInt(moneyValue.noUiSlider.get());

        $('#moneyValueInput').val(moneyValueNumber);
        $('.slider-value').text(moneyValueNumber.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ") + ' Kč');

        if($(window).width() < 768) {
            if (moneyValueNumber <= 600000) {
                $(moneyValue).addClass('min-range');
            } else {
                $(moneyValue).removeClass('min-range');
            }
            if (moneyValueNumber >= 2800000) {
                $(moneyValue).addClass('max-range')
            } else {
                $(moneyValue).removeClass('max-range');
            }
        }
    });


    $('.clients').slick({
        dots: false,
        // centerMode: true,
        slidesToShow: 2,
        slidesToScroll: 2,
        responsive: [
            //{
            //    breakpoint: 1024,
            //    settings: {
            //        slidesToShow: 3,
            //        slidesToScroll: 3,
            //        infinite: true,
            //        dots: true
            //    }
            //},
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            },
            //{
            //    breakpoint: 480,
            //    settings: {
            //        slidesToShow: 1,
            //        slidesToScroll: 1
            //    }
            //}
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
        ]
    });

    function calculateClientHeight() {
        var maxClientHeight = 0,
            clients = $('.client');
        clients.each(function() {
            maxClientHeight = Math.max(maxClientHeight, $(this).outerHeight());
        });

        clients.css({height: maxClientHeight + 'px'})
    }

    calculateClientHeight();

    $(window).resize(function() {
        calculateClientHeight();
    });

    $('.partners').slick({
        dots: false,
        arrows: false,
        // centerMode: true,
        infinite: true,
        //slidesToShow: 2,
        slidesToScroll: 3,
        centerMode: true,
        variableWidth: true,
        autoplay: true,
        autoplaySpeed: 2000
    });

    $('.partner').each(function(i, p) {
        var $p = $(p),
            img = $p.find('img');
        $p.append('<span class="partner__over"><img src="' + img.attr('src') + '" alt="' + img.attr('alt') +  '" /></span>')

        $p.on('click', function(evt) {
            evt.preventDefault();
            $('html, body').animate({
                scrollTop: $p.offset().top - Math.round($(window).innerHeight() / 2) + 'px'
            }, 200);
        })
    });

    $('.nav--mobile').on('click', function(evt) {
        evt.preventDefault();

        $(this).toggleClass('nav--mobile--active');
        $('.nav--top').toggleClass('nav--top--active');
    });

    //$('.scrolldown').on('click', function(evt) {
    //    evt.preventDefault();
    //
    //    $('html, body').animate({
    //        scrollTop: $($(this).attr('href')).offset().top + 'px'
    //    }, 300);
    //});

    $('.scrollto').on('click', function(evt) {
        evt.preventDefault();

        $('html, body').animate({
            scrollTop: $($(this).attr('href')).offset().top + 'px'
        }, 300);

        if(typeof $(this).data('tab') != "undefined") {
            $('a[href="#' + $(this).data('tab') + '"]').trigger('click');
        }
    });

    $('.news__item').on('click', function(evt) {
        evt.preventDefault();

        var target = $($(this).attr('href')),
            targetDependentHeight = target.outerHeight() + 2*$('.news__details').css('padding-top'),
            finalHeight;

        finalHeight = targetDependentHeight > $(document).height() ? targetDependentHeight : $(document).height();

        cache.prevPosition = $(window).scrollTop();


        $('.news__details')
            .removeClass('hidden')
            .css({
                height: finalHeight
            });

        target.removeClass('hidden');

        target.append($('.news__detail__close'));

        $('html, body').animate({
            scrollTop: '0px'
        }, 800);
    });

    function closeDetail() {
        $('.news__details__item:visible').fadeOut(500, function() {
            $(this).addClass('hidden').removeAttr('style');
        });

        $('.news__details').fadeOut(500, function() {
            $(this).addClass('hidden').removeAttr('style');
        });

        $('html, body').animate({
            scrollTop: cache.prevPosition + 'px'
        }, 800);

    }

    $('.news__detail__close').on('click', function(evt) {
        evt.preventDefault();
        evt.stopPropagation();
        closeDetail();
    });

    $('.news__details').on('click', function(evt) {
        evt.preventDefault();
        evt.stopPropagation();

        if($.inArray('news__details', evt.currentTarget.classList) > -1) {
            closeDetail();
        }
    });

    // IE9 placeholder polyfill
    if (!('placeholder' in document.createElement('input'))) {

        $('[placeholder]').focus(function() {
            var input = $(this);
            if (input.val() == input.attr('placeholder')) {
                input.val('');
                input.removeClass('placeholder');
            }
        }).blur(function() {
            var input = $(this);
            if (input.val() == '' || input.val() == input.attr('placeholder')) {
                input.addClass('placeholder');
                input.val(input.attr('placeholder'));
            }
        }).blur();

        $('[placeholder]').parents('form').submit(function() {
            $(this).find('[placeholder]').each(function() {
                var input = $(this);
                if (input.val() == input.attr('placeholder')) {
                    input.val('');
                }
            })
        });
    }
});