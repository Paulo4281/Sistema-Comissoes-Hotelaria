$(document).ready(() => {
    $.ajax({
        url: 'SuperADM-carregar',
        type: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
        },
        success: function(response) {
            if (response.status == 1) {
                let usuarios = response.dados;
                let tbody = $('#tbody-superadm-cadastrados');
                usuarios.forEach(usuario => {
                    let tr = $('<tr>');
                
                    tr
                        .append($('<td>').append($('<span>').text(`${usuario.nome} ${usuario.sobrenome}`)))
                        .append($('<td>').append($('<span>').text(usuario.email)))
                        .append($('<td>').append($('<span>').text(usuario.DATA_CADASTRO)));
                
                    tbody.append(tr);
                });


            }
            return false;
        }
    })
});