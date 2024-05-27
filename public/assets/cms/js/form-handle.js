"use strict";
$(document).ready(function () {

    // handle ajax response
    function handleAjaxResponse(response, form, submitSuccess, notify, btnSubmit, btnSubmitText, btnSubmitIcon) {
        if (response.status === true) {
            if (submitSuccess) {
                form.trigger('reset');
            }

            if (response.data && response.data.redirect) {
                setTimeout(function () {
                    window.location.href = response.data.redirect;
                }, 7000);
            }


            if (notify) {
                $.notify({
                    message: response.message
                }, {
                    type: 'success'
                });
            }
        } else {
            if (notify) {
                $.notify({
                    message: response.message
                }, {
                    type: 'danger'
                });
            }
        }
    }

    // reset submit button
    function resetSubmitButton(btnSubmit, btnSubmitText, btnSubmitIcon) {
        if (btnSubmit.data('loading-text')) {
            btnSubmit.html('<i class="' + btnSubmitIcon + '"></i> ' + btnSubmitText);
        } else {
            btnSubmit.find('i').attr('class', btnSubmitIcon);
        }

        btnSubmit.prop('disabled', false);
    }

    // send request from ajax
    function sendRequestFromAjax(form, formData, btnSubmit, btnSubmitText, btnSubmitIcon, captureToken = null) {
        let submitSuccess = form.data('success');
        let notify = form.data('notify') || false;

        if (captureToken) {
            formData.append('g-recapture-response', captureToken);
        }

        $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            cache: false,
        }).then(
            function (response) {
                handleAjaxResponse(response, form, submitSuccess, notify, btnSubmit, btnSubmitText, btnSubmitIcon);
            }
        ).always(function () {
            resetSubmitButton(btnSubmit, btnSubmitText, btnSubmitIcon);
        }
        );

    }

    // form submit handler
    $(document).on('submit', '.form-ajax-handle', function (e) {
        if (e.isDefaultPrevented()) {
            return false;
        }

        e.preventDefault();

        let form = $(this);
        let formData = new FormData(form[0]);
        let btnSubmit = form.find('button[type="submit"]');
        let btnSubmitText = btnSubmit.text();
        let btnSubmitIcon = btnSubmit.find('i').attr('class');

        btnSubmit.find('i').attr('class', 'fas fa-spinner fa-spin');
        btnSubmit.prop('disabled', true);

        if (btnSubmit.data('loading-text')) {
            btnSubmit.html('<i class="fas fa-spinner fa-spin"></i> ' + btnSubmit.data('loading-text'));
        }

        sendRequestFromAjax(form, formData, btnSubmit, btnSubmitText, btnSubmitIcon)

    });
});