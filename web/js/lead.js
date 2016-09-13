(function(window, document, undefined) {
	var Lead = {
		cache: {
			serverError: '<div class="form__layer--error"><p class="form__layer--error__text">Omlouváme se, ale nastala chyba, prosím zopakujte odeslání později.</p></div>'
		},
		utils: {}
	};
	Lead.formInit = function() {
		Lead.cache.contactContainer = $('body').find('#tab--1');
		Lead.cache.form = Lead.cache.contactContainer.find('form');

		Lead.cache.form.off('submit').on('submit', function(e) {
			e.preventDefault();

			var form = $(this);
			Lead.cache.contactContainer.css('height',form.outerHeight());

			form.find('.form__layer--error,.form__layer--success').remove();
			form.find('.form__row').removeClass('form_row--error');

			form.find('input[name$="answer_to_the_ultimate_question_of_life_the_universe_and_everything]"]').val('42');

			$.ajax({
				type    : 'post',
				url     : form.attr('action'),
				data    : form.serialize(),
				dataType: 'json',
				success : function (response) {
					if (!response || typeof response != 'object' || (!response.success && response.error)) {
						form.find('.form__row--submit').prepend(Lead.cache.serverError);
						Lead.cache.contactContainer.css('height','auto');
						return;
					}

					if (typeof response.data.template != 'undefined') {
						var content = $('<div/>').html(response.data.template);

						if (content.find('.form__layer--success').length) {
							content.find('input:text').val('');
						}

						Lead.cache.contactContainer.html(content);
						Lead.formInit();

						var moneyValue = $('#moneyValue')[0];

						noUiSlider.create(moneyValue, {
					        range: {
					            'min': 350000,
					            'max': 3000000
					        },
					        //snap: true,
					        start: $('#moneyValueInput').val(),
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

						//ga('send', 'event', 'Lead form', 'send');
					}

					Lead.cache.contactContainer.css('height','auto');
				},
				error   : function () {
					form.find('.form__row--submit').prepend(Lead.cache.serverError);
					Lead.cache.contactContainer.css('height','auto');
				}
			});
		});
	}
	Lead.formInit();
})(window, document);