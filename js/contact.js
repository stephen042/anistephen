/* Contact form AJAX submission (jQuery).
 * Intercepts #contact-form, validates in the browser, POSTs to
 * contact-submit.php, renders the JSON result inline — no page reload.
 * Server-side validation in includes/contact-submit.php is authoritative.
 */
(function ($) {
    'use strict';

    $(function () {
        var $form = $('#contact-form');
        if (!$form.length) {
            return;
        }

        var $btn = $('#contact-submit-btn');
        var $feedback = $('#contact-feedback');
        var originalBtnText = $btn.text();
        var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        function showFeedback(type, text) {
            $feedback
                .removeClass('d-none alert-success alert-danger')
                .addClass('alert-' + type)
                .text(text);
        }

        function hideFeedback() {
            $feedback.addClass('d-none').removeClass('alert-success alert-danger').text('');
        }

        function setFieldError(name, message) {
            var $field = $form.find('[name="' + name + '"]');
            var $error = $form.find('[data-error-for="' + name + '"]');
            if (message) {
                $field.addClass('is-invalid');
                $error.text(message).show();
            } else {
                $field.removeClass('is-invalid');
                $error.text('').hide();
            }
        }

        function clearFieldErrors() {
            $.each(['name', 'email', 'subject', 'message'], function (_, field) {
                setFieldError(field, '');
            });
        }

        // Clear stale messages as soon as the user starts a new attempt.
        $form.on('input change', 'input, textarea', function () {
            hideFeedback();
            var fieldName = $(this).attr('name');
            if (fieldName) {
                setFieldError(fieldName, '');
            }
        });

        $form.on('submit', function (e) {
            e.preventDefault();
            hideFeedback();
            clearFieldErrors();

            var name = $.trim($('#name').val() || '');
            var email = $.trim($('#email').val() || '');
            var subject = $.trim($('#subject').val() || '');
            var message = $.trim($('#message').val() || '');

            // --- Browser-side validation (mirrored on the server). ---
            var clientErrors = {};
            if (!name) {
                clientErrors.name = 'Please enter your name.';
            }
            if (!email) {
                clientErrors.email = 'Please enter your email address.';
            } else if (!emailPattern.test(email)) {
                clientErrors.email = 'Please enter a valid email address.';
            }
            if (!subject) {
                clientErrors.subject = 'Please enter a subject.';
            }
            if (!message) {
                clientErrors.message = 'Please enter a message.';
            }

            if (!$.isEmptyObject(clientErrors)) {
                $.each(clientErrors, function (field, msg) {
                    setFieldError(field, msg);
                });
                showFeedback('danger', 'Please check the form and try again.');
                return;
            }

            // --- Sending state. ---
            $btn.prop('disabled', true).text('Sending...');

            $.ajax({
                url: $form.attr('action') || 'contact-submit.php',
                method: 'POST',
                data: $form.serialize(),
                dataType: 'json'
            })
                .done(function (response) {
                    if (response && response.success) {
                        showFeedback('success', '\u2713 ' + (response.message || "Message sent successfully. I'll get back to you soon."));
                        $form[0].reset();
                        clearFieldErrors();
                        if (response.csrf_token) {
                            $form.find('input[name="csrf_token"]').val(response.csrf_token);
                        }
                    } else if (response && response.errors && !$.isEmptyObject(response.errors)) {
                        $.each(response.errors, function (field, msg) {
                            setFieldError(field, msg);
                        });
                        showFeedback('danger', response.message || 'Please check the form and try again.');
                    } else {
                        showFeedback('danger', (response && response.message) || 'Unable to send your message right now. Please try again.');
                    }
                })
                .fail(function (jqXHR) {
                    var msg = 'Unable to send your message right now. Please try again.';
                    var data = jqXHR && jqXHR.responseJSON;
                    if (data) {
                        if (data.errors && !$.isEmptyObject(data.errors)) {
                            $.each(data.errors, function (field, errMsg) {
                                setFieldError(field, errMsg);
                            });
                        }
                        if (data.message) {
                            msg = data.message;
                        }
                    }
                    showFeedback('danger', msg);
                })
                .always(function () {
                    $btn.prop('disabled', false).text(originalBtnText);
                });
        });
    });
})(jQuery);
