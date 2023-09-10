function excluirReserva(reserva) {

    let modalExcluir = $('#modal-excluir-reserva');
    modalExcluir.modal('show');    

    let id = reserva.id.split("_")[1];

    $('#excluir-reserva').on('click', () => {

        $.ajax({
            url: 'excluir-reserva',
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                id: id,
            },
            success: function(response) {
                if (response.status == 1) {

                    modalExcluir.modal('hide');
                    
                    let modalReservaExcluida = $('#modal-reserva-excluida');
                    modalReservaExcluida.modal('show');

                    setTimeout(() => {
                        location.reload();
                    }, 1500);

                    return true;
                }
                return false;
            }
        });

    });

    $('#cancelar-excluir-reserva').on('click', () => {
        modalExcluir.modal('hide');
    })

}