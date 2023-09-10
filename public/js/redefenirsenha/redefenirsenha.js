
$(document).ready(() => {

    // ESCONDE SPAN DOS ERROS //

    var errorSpans = $('.error');

    errorSpans.hide();
    
    // ** //
});

var errorSpans = $('.error');

function verificarEmail() {

    let email = $('#input-email').val();
    let loadGif = $('#redefenir-senha-load-gif');
    let btnText = $('#redefenir-senha-btn-text');
    let btn = $('#redefenir-senha-button');

    if (email == '') {
        errorSpans.eq(0).show();
        errorSpans.eq(1).hide();
        return false;
    }

    btn.prop('disabled', true);
    loadGif.addClass('spinner-border spinner-border-sm');
    btnText.text('Aguarde...');
    
    $.ajax({
        url: 'verificarredefenirsenha',
        type: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            email: email,
        },
        success: function(response) {
            if (response.status == 0) {
                errorSpans.eq(1).show();
                errorSpans.eq(0).hide();
                btn.prop('disabled', false);
                loadGif.removeClass('spinner-border spinner-border-sm');
                btnText.text('Redefenir Senha');
                return false;
            } else if (response.status == 1) {
                window.location.href = "/redefenirsenhacodigo";
            } else {
                btn.prop('disabled', false);
                loadGif.removeClass('spinner-border spinner-border-sm');
                btnText.text('Redefenir Senha');
                errorSpans.eq(1).show();
                errorSpans.eq(0).hide();
            }
        }
    });
}