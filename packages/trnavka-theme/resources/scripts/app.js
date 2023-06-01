//import './styles/app.scss';
import 'bootstrap';
import $ from 'jquery';
import {Modal} from 'bootstrap';

$(document).ready(function () {
    const dajnatoCTAModal = new Modal('#dajnato-cta-modal');

    $('body')
        .on('click', '.btn-dajnato-cta', function () {
            const $button = $(this);
            const url = $button.data('form-url');
            const dialog = $('#dajnato-cta-modal .modal-dialog');
            const buttonText = $button.text();

            if ('BUTTON' === $button.prop('tagName')) {
                $button.text('Čakajte...').prop('disabled', true);
            }

            $.get(url).then((response) => {
                dialog.html($(response).find('.modal-dialog').html());
                dajnatoCTAModal.show();

                if ('BUTTON' === $button.prop('tagName')) {
                    $button.text(buttonText).prop('disabled', false);
                }
            });
        })
        .on('change', '.js-subscription-widget', function () {
            $('input[name="donation[amount]"][value="' + $(this).val() + '"]').prop('checked', true);
        })
        .on('submit', '.js-donation-form form', function (event) {
            event.preventDefault();
            const $form = $(this);
            $form.find('button[type=submit]').text('Odosielam...').prop('disabled', true);

            $.ajax({
                url: $form.attr('action') ?? location.href,
                data: $form.serialize(),
                type: 'POST'
            }).done((response, status, jqXHR) => {
                const $html = $(response);

                if ($html.find('.js-darujme-form form').length > 0) {
                    const $form = $html.find('.js-darujme-form form');
                    $('.js-darujme-form-holder').append($form);
                    $form.submit();
                }
                else {
                    $form.replaceWith($html.find('.js-donation-form form'));

                    let top = 0;

                    $('.is-invalid:first').parents('#donationModal .modal-dialog *').each(function () {
                        top = Math.max(top, $(this).position().top);
                    });

                    $form.scrollTop(top);
                }
            });
        })
        .on('change', 'input[name="donation[onetimeOrRecurring]"]', function () {
            const $form = $(this).closest('form');
            $form.find('.onetime-or-recurring').addClass('d-none');
            $form.find('.onetime-or-recurring.' + $(this).val()).removeClass('d-none');
        })
        .on('change', 'input[name="donation[recurringAmount]"], input[name="donation[onetimeAmount]"]', function () {
            const $triggeredInput = $(this);
            const $form = $triggeredInput.closest('form');

            let index = 0;
            $form.find('input[name="' + $triggeredInput.attr('name') + '"]').each((i, input) => {
                if ($(input).prop('checked')) {
                    index = i;
                }
            });

            $(['donation[recurringAmount]', 'donation[onetimeAmount]']).each((j, name) => {
                if (name !== $triggeredInput.attr('name')) {
                    $form.find('input[name="' + name + '"]').each((i, input) => {
                        if (i === index) {
                            $(input).prop('checked', true);
                        }
                    });
                }
            });

            if ('T' === $(this).data('is-other')) {
                $form.find('.js-other-sum').removeClass('d-none');
            } else {
                $form.find('.js-other-sum').addClass('d-none');
            }
        });
});
