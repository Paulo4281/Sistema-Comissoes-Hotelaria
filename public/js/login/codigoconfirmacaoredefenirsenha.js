$(document).ready(() => {

    let errorSpans = $('.error');
    errorSpans.hide();

    let inputCodigo = $('#input-codigo');
    inputCodigo.mask('999999');

});

var errorSpans = $('.error');

function verificarCodigo() {
    let codigo = $('#input-codigo').val();

    if (codigo == '') {
        errorSpans.show();
    }

    $.ajax({
        url: 'validarcodigoredefenirsenha',
        data: {
        _token: $('meta[name="csrf-token"]').attr('content'),
        codigo: codigo,
        },
        type: 'POST',
        success: function(response) {
            if (response.status == 1) {
                errorSpans.eq(0).hide();
                window.location.href = '/inserirnovasenha';
            } else if (response.status == 0) {
                errorSpans.eq(0).show();
                return false;
            } else {
                return false;
            }
        }
    });
}