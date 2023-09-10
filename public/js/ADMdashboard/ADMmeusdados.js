function ADMmeusDados() {
    $.ajax({
        url: 'carregarmeusdados',
        type: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
        },
        success: function(response) {
            if (response.status == 1) {

                let dados = response.dados;
                let meusDadosModal = $('#modal-meus-dados');
                let tbody = $('#tbody-meus-dados');

                if (tbody.children().length > 0) {
                    meusDadosModal.modal('show');
                    return false;
                } else {
                    let dataRow = $('<tr>')
                    .append($('<td>').append($('<span>').text(`${dados[0].nome} ${dados[0].sobrenome}`)))
                    .append($('<td>').append($('<span>').text(dados[0].email)))
                    .append($('<td>').append($('<span>').text(dados[0].DATA_CADASTRO)));
        
                tbody.append(dataRow);
                meusDadosModal.modal('show');
                }

            } else if (response.status == 0) {
                window.location.href = 'login';
                return false;
            }

            return false;
        }
    })
}