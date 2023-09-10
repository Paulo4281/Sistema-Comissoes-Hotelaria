$(document).ready(() => {
    let form = $('#form-reservas-cadastradas');
    let groups = {};
    let atualizarReservaBtn = $('#input-atualizar-reserva');

    form.find('div[class^="group"]').each(function() {
        let groupName = $(this).attr('class').split(' ')[0];
        groups[groupName] = {
            idReserva: [],
            operadora: [],
            titular: [],
            sobrenome: [],
            check_in: [],
            check_out: [],
            roomnights: [],
            valor: [],
            aptos: [],
            previsao: [],
        };
    });

    atualizarReservaBtn.on('click', () => {
        atualizarReserva(groups);
    });

    form.on('input', (event) => {
        let input = $(event.target);
        let group = input.closest('div[class^="group"]').attr('class').split(' ')[0];
        let inputType = input.attr('data-group');
        let value = input.val();


        if (atualizarReservaBtn.prop('disabled') == true) {
            atualizarReservaBtn.removeClass('btn-secondary');
            atualizarReservaBtn.addClass('btn-primary');
            atualizarReservaBtn.prop('disabled', false);
        }

        if (input.attr('type') === 'number') {
            value = value.toString();
        }

        if (!groups[group]) {
            groups[group] = {};
        }

        if (!groups[group][inputType]) {
            groups[group][inputType] = [value];
        } else {
            groups[group][inputType][0] = value;
        }
        
        if ("check_in" in groups[group]) {
            let check_out = input.closest('tr').find('input[data-group="check_out"]').val();
            groups[group]['check_out'] = check_out;
        }
        
        if (!groups[group]['idReserva']) {
            groups[group]['idReserva'] = [];
        }
        
        setTimeout(() => {
            let idReserva = input.closest('tr').find('input[data-group="idReserva"]').val();
            groups[group]['idReserva'][0] = idReserva;
    
            let roomnights = input.closest('tr').find('input[data-group="roomnights"]').val();
            groups[group]['roomnights'] = roomnights;
    
            let valor = input.closest('tr').find('input[data-group="valor"]').val();
            groups[group]['valor'] = valor;
    
            let previsao = input.closest('tr').find('input[data-group="previsao"]').val();
            groups[group]['previsao'] = previsao;
    
        }, 200);

    });
});

function atualizarReserva(groups) {
    var atualizacoes = groups == undefined ? null : groups;

    if (atualizacoes != null) {
        $.ajax({
            url: 'atualizar-reserva',
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                atualizacoes: JSON.stringify(atualizacoes),
            },
            success: function(response) {
                if (response.status == 1) {
                    let modalSuccess = $('#modal-reservas-atualizadas');
                    modalSuccess.modal('show');
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                    return true;
                }
                return false;
            }
        });
    }
}
