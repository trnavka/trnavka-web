//import './styles/app.scss';
import 'bootstrap';
import $ from 'jquery';

$(document).ready(function () {
    $('body')
        .on('change', '.js-subscription-widget', function() {
            $('input[name="donation[amount]"][value="' + $(this).val() + '"]').prop('checked', true);
        })
        .on('submit', '.js-donation-form form', function (event) {
            const $form = $(this);
            event.preventDefault();

            $.ajax({
                url: $form.attr('action') ?? location.href,
                data: $form.serialize(),
                type: 'POST'
            }).done((response, status, jqXHR) => {
                const $html = $(response);
                if ($html.find('.js-donation-form form').length > 0) {
                    $('.js-donation-form form').replaceWith($html.find('.js-donation-form form'));

                    let top = 0;

                    $('.is-invalid:first').parents('#donationModal .modal-dialog *').each(function() {
                        top = Math.max(top, $(this).position().top);
                    });

                    $('#donationModal').scrollTop(top);
                }

                if ($html.find('.js-darujme-form form').length > 0) {
                    const $form = $html.find('.js-darujme-form form');
                    $('.js-darujme-form-holder').append($form);
                    $form.submit();
                }
            });
        })
        .on('change', 'input[name="donation[periodicity]"]', function () {
            $('.js-payment-type').addClass('d-none');
            $('.js-payment-type input:checked').prop('checked', false);
            $('.js-' + $(this).val() + '-payment-type').removeClass('d-none');
        })
        .on('change', 'input[name="donation[amount]"]', function () {
            if ('T' === $(this).data('is-other')) {
                $('.js-other-sum').removeClass('d-none');
            } else {
                $('.js-other-sum').addClass('d-none');
            }
        });
});
