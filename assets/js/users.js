$(function() {
    $('.container').on('click', 'input[name="choose"]', onClickRadioChoose);
    $('.container').on('click', 'button[type="submit"]', onClickSubmitForm);

    function onClickRadioChoose() {
        let chooseValue = $(this).val();
        let accountInput = $('.container').find('input[name="account"]');
        let accountLabel = $('.container').find('label[for="account"]');

        if(chooseValue == 1) {
            accountInput.attr('required', true);
            accountLabel.addClass('required');
        }

        if(chooseValue == 2) {
            accountInput.attr('required', false);
            accountLabel.removeClass('required');
        }
    }

    function onClickSubmitForm() {
        let container = $('.container');
        let form = container.find('form');
        let url = form.attr('action');
        let formData = new FormData(document.querySelector('form'));
    
        form.on("submit", function (e) {
            e.preventDefault();
        });
    
        $.ajax({
            url: url,
            data: formData,
            type: "POST",
            processData: false,
            contentType: false,
            success: function (data) {
                if (data.status) {
                    snackbar("#success_container").setText('Dane zostały zapisane!').showAndHide();

                    container.find('.email-domain-counter').text(data.data.surname_count);
                    container.find('.surname-counter').text(data.data.domain_count);
    
                    setTimeout(function() {
                        window.location.href = 'index.php';
                    }, 1000);
                }
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    let response = JSON.parse(xhr.responseText);
                    let errorMessages = Array.isArray(response.data) ? response.data : [response.data];
                    let errorText = errorMessages.join('<br>');
                    snackbar("#errors_container").setHtml(errorText).showAndHide();
                } else {
                    snackbar("#errors_container").setText('Wystąpił błąd podczas wysyłania formularza. Spróbuj ponownie później.').showAndHide();
                }
            }
        });
    }    

    $(document).ready(function () {
        $(document).ready(function () {
            $('input[name="account"]').mask('PL00 0000 0000 0000 0000 0000 0000', {
                translation: {
                    '0': { pattern: /\d/, optional: false }
                },
                placeholder: 'PL__ ____ ____ ____ ____ ____ ____',
                clearIfNotMatch: false
            });
        });
        $('input[name="client_no"]').mask('000DDD-WWWWW', {
            translation: {
                '0': { pattern: /0/, optional: false },
                'D': { pattern: /\d/, optional: false },
                'W': { pattern: /[A-Z]/, optional: false }
            },
            placeholder: '000DDD-WWWWW',
            clearIfNotMatch: false
        }); 
    });
});
