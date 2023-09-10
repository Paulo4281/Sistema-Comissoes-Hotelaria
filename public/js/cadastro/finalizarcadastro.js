function finalizarCadastro() {
    $.ajax({
        url: 'finalizarcadastro',
        data: {
        _token: $('meta[name="csrf-token"]').attr('content'),
        },
        type: 'POST',
        success: function(response) {
            if (response.status == 1) {
                window.location.href = 'login';
            }
        }
    })
}