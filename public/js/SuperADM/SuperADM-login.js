$(document).ready(() => {
    $('.error').hide();
});

function verificarLogin() {

    let email = $('#input-email').val();
    let senha = $('#input-senha').val();

    let errorSpans = $('.error');

    if (email == '' || senha == '') {
        errorSpans.eq(1).show();
        errorSpans.eq(0).hide();
        errorSpans.eq(2).hide();
        return false;
    }

    $.ajax({
        url: 'SuperADM-verificar-login',
        type: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            email: email,
            senha: senha,
        },
        success: function(response) {
            if (response.status == 1) {
                window.location.href = 'SuperADM-dashboard';
                return true;
            } else if (response.status == 2) {
                errorSpans.eq(2).show();
                errorSpans.eq(0).hide();
                errorSpans.eq(1).hide();
                return false;
            } else {
                errorSpans.eq(0).show();
                errorSpans.eq(1).hide();
                errorSpans.eq(2).hide();
                return false;
            }
            errorSpans.eq(0).show();
            errorSpans.eq(1).hide();
            errorSpans.eq(2).hide();
            return false;
        }
    });

}