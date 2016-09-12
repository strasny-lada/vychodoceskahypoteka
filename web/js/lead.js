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

						noUiSlider.create(moneyValue, {
					        range: {
					            'min': 350000,
					            'max': 3000000
					        },
					        //snap: true,
					        start: 400000,
					        step: 50000
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