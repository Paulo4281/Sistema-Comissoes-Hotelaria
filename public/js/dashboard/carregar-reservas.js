function ativarTool() {
    $('[data-bs-toggle="tooltip"]').tooltip();
}

function callTip() {
    
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl, {
                    trigger: 'hover focus'
                });
            });

}
        

$(document).ready(() => {
    $.ajax({
        url: 'carregar-reservas',
        type: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
        },
        success: function(response) {
            console.log(response);
            
            if (response.status == 1) {

                let form = $('#form-reservas-cadastradas').addClass('fs-5 mt-3 mb-2');

                let reservas = (response.reservas);

                let valorAReceberInput = $('#input-valor-a-receber');
                let valorRecebidoInput = $('#input-valor-recebido');
                let valorAReceber = 0;
                let valorRecebido = 0;
                let groupCounter = 0;
                
                function calcularNoites(checkInDate, checkOutDate) {
                    const oneDay = 24 * 60 * 60 * 1000;
                    const checkIn = new Date(checkInDate);
                    const checkOut = new Date(checkOutDate);
                    const diffDays = Math.round(Math.abs((checkOut - checkIn) / oneDay));
                    return diffDays;
                }

                reservas.forEach(reserva => {
                    
                    let aptos = $('<select>').addClass('form-control').attr('data-bs-toggle', 'tooltip').attr('title', 'Apartamentos').attr('data-group', 'aptos').attr('onchange', 'numeroAptos(event)');
                    let div = $('<div>').attr('class', `group${groupCounter}`);
                    groupCounter++;

                    for (let i = 1; i < 11; i++) {
                        let option = $('<option>').val(i).text(i);
                        if (reserva.aptos == option.val()) {
                            option.attr('selected', 'selected');
                        }
                        aptos.append(option);
                    }

                    let trBackColor = '#ffe7c4';
                    let trSecBackColor = '#ffeacc';
                    
                    if (reserva.status == 'nao_pago') {
                        reserva.status = 'Não Pago';
                        valorAReceber += Number(reserva.valor);
                        valorAReceberInput.val(formatarDinheiro(valorAReceber));
                        const diffDays = calcularNoites(reserva.check_in, reserva.check_out);

                        
                        div.append($('<tr>')
                        .append($('<td>').addClass('py-2').append($('<input>').addClass('form-control').attr('data-group', 'idReserva').attr('type', 'hidden').val(reserva.idReserva)))
                        .append($('<td>').addClass('py-2').append($('<input>').css('background', `${trBackColor}`).addClass('form-control').attr('data-bs-toggle', 'tooltip').attr('title', 'Operadora').attr('data-group', 'operadora').val(reserva.operadora)))
                        .append($('<td>').addClass('py-2').append($('<input>').css('background', `${trSecBackColor}`).addClass('form-control').attr('data-bs-toggle', 'tooltip').attr('title', 'Titular').attr('data-group', 'titular').val(reserva.titular)))
                        .append($('<td>').addClass('py-2').append($('<input>').css('background', `${trBackColor}`).addClass('form-control').attr('data-bs-toggle', 'tooltip').attr('title', 'Sobrenome').attr('data-group', 'sobrenome').val(reserva.sobrenome)))
                        .append($('<td>').addClass('py-2').append($('<input>').css('background', `${trSecBackColor}`).addClass('form-control').attr('data-bs-toggle', 'tooltip').attr('title', 'Check-in').attr('data-group', 'check_in').attr('onchange', 'calcularMinimoNoites(event)').attr('type', 'date').val(reserva.check_in)))
                        .append($('<td>').addClass('py-2').append($('<input>').css('background', `${trBackColor}`).addClass('form-control').attr('data-bs-toggle', 'tooltip').attr('title', 'Check-out').attr('data-group', 'check_out').attr('onchange', 'calcularMinimoNoites(event)').attr('type', 'date').val(reserva.check_out)))
                        .append($('<td>').addClass('py-2').append($(aptos).css('background', `${trSecBackColor}`)))
                        .append($('<td>').addClass('py-2').append($('<input>').css('background', `${trBackColor}`).addClass('form-control unchangeable').attr('data-bs-toggle', 'tooltip').attr('title', 'Noites').attr('data-group', 'roomnights').prop('readonly', true).val(diffDays)))
                        .append($('<td>').addClass('py-2').append($('<input>').css('background', `${trSecBackColor}`).addClass('form-control unchangeable').attr('data-bs-toggle', 'tooltip').attr('title', 'Valor').attr('data-group', 'valor').prop('readonly', true).val(reserva.valor)))
                        .append($('<td>').addClass('py-2').append($('<input>').css('background', `${trBackColor}`).addClass('form-control unchangeable').attr('data-bs-toggle', 'tooltip').attr('title', 'Previsão de pagamento').attr('data-group', 'previsao').prop('readonly', true).val(reserva.previsao)))
                        .append($('<td>').addClass('py-2').append($('<input>').css('background', `${trSecBackColor}`).addClass('form-control unchangeable').attr('data-bs-toggle', 'tooltip').attr('title', 'Status').prop('readonly', true).val(reserva.status)))
                        .append($('<td>').addClass('py-2').append($('<input>').addClass('btn btn-danger').attr('type', 'button').attr('id', `excluir-reserva_${reserva.idReserva}`).attr('onclick', 'excluirReserva(this)').val('Excluir')))
                        ).addClass('mb-3 p-1').appendTo(form);
                        
                    }

                    ativarTool();
                    callTip();
                    
                    if (reserva.status == 'pago') {
                        reserva.status = 'Pago';
                        valorRecebido += Number(reserva.valor);
                        valorRecebidoInput.val(formatarDinheiro(valorRecebido));
                        $('<tr>')
                        .append($('<td>').addClass('py-2').append($('<input>').attr('data-bs-toggle', 'tooltip').attr('title', 'Operadora').addClass('form-control unchangeable').prop('readonly', true).val(reserva.operadora)))
                        .append($('<td>').addClass('py-2').append($('<input>').attr('data-bs-toggle', 'tooltip').attr('title', 'Titular').addClass('form-control unchangeable').prop('readonly', true).val(reserva.titular)))
                        .append($('<td>').addClass('py-2').append($('<input>').attr('data-bs-toggle', 'tooltip').attr('title', 'Sobrenome').addClass('form-control unchangeable').prop('readonly', true).val(reserva.sobrenome)))
                        .append($('<td>').addClass('py-2').append($('<input>').attr('data-bs-toggle', 'tooltip').attr('title', 'Check-in').addClass('form-control unchangeable').prop('readonly', true).attr('type', 'date').val(reserva.check_in)))
                        .append($('<td>').addClass('py-2').append($('<input>').attr('data-bs-toggle', 'tooltip').attr('title', 'Check-out').addClass('form-control unchangeable').prop('readonly', true).attr('type', 'date').val(reserva.check_out)))
                        .append($('<td>').addClass('py-2').append($('<select>').attr('data-bs-toggle', 'tooltip').attr('title', 'Apartamentos').addClass('form-control unchangeable').prop('readonly', true).append($('<option>').val(reserva.aptos).text(reserva.aptos))))
                        .append($('<td>').addClass('py-2').append($('<input>').attr('data-bs-toggle', 'tooltip').attr('title', 'Noites').addClass('form-control unchangeable').prop('readonly', true).val(reserva.nights)))
                        .append($('<td>').addClass('py-2').append($('<input>').attr('data-bs-toggle', 'tooltip').attr('title', 'Valor').addClass('form-control unchangeable').prop('readonly', true).val(reserva.valor)))
                        .append($('<td>').addClass('py-2').append($('<input>').attr('data-bs-toggle', 'tooltip').attr('title', 'Data do pagamento').addClass('form-control unchangeable').prop('readonly', true).val(formatarData(reserva.data_pagamento))))
                        .append($('<td>').addClass('py-2').append($('<input>').attr('data-bs-toggle', 'tooltip').attr('title', 'Status').addClass('form-control status-pago').prop('readonly', true).val(reserva.status)))
                        .appendTo(form);
                    }  

                    if (valorRecebido == 0) {
                        valorRecebidoInput.val(formatarDinheiro(0));
                    }
                    
                });

            } else if (response.status == 2) {
                
            } else if (response.status == 0) {                
                let modalPrimeiraReserva = $('#modal-primeira-reserva');
                modalPrimeiraReserva.modal('show');
                return false;
            }
            return false;
        }
    })
});

function numeroAptos(event) {
    let valor = $(event.target).closest('tr').find('[data-group="valor"]');
    let roomnights = $(event.target).closest('tr').find('[data-group="roomnights"]');
    let aptos = $(event.target);

    valor.val((roomnights.val() * config.valorComissao) * aptos.val())
}

function calcularPrevisao(checkOutDate) {
    let previsaoDate = new Date(checkOutDate);
    previsaoDate.setDate(previsaoDate.getDate() + 15);
    return previsaoDate.toISOString().substring(0, 10);
}

function calcularMinimoNoites(event) {
    let input = $(event.target)[0].dataset.group;

    let checkIn = 0;
    let checkOut = 0;
    let valor = $(event.target).closest('tr').find('[data-group="valor"]');
    let roomnights = $(event.target).closest('tr').find('[data-group="roomnights"]');
    let aptos = $(event.target).closest('tr').find('[data-group="aptos"]');
    let previsao = $(event.target).closest('tr').find('[data-group="previsao"]');
    
    if ($(event.target)[0].dataset.group === 'check_in') {
        checkIn = $(event.target);
        checkOut = checkIn.closest('tr').find('[data-group="check_out"]');
    } else if ($(event.target)[0].dataset.group === 'check_out') {
        checkOut = $(event.target);
        checkIn = checkOut.closest('tr').find('[data-group="check_in"]');
    }

    let periodoMinimo = config.periodoMinimo;

    if (input === 'check_in') {
        const checkIn_date = new Date(checkIn.val());
        const checkOut_date = new Date(checkOut.val());

        if (checkOut.val() !== '') {
            const diffInTime = checkOut_date - checkIn_date;
            const diffInDays = diffInTime / (1000 * 3600 * 24);

            roomnights.val(diffInDays);
            valor.val((diffInDays * config.valorComissao) * aptos.val())
            previsao.val(calcularPrevisao(checkOut.val()));

            if (diffInDays >= 4) {
                return false;
            }
            
        }

        const minCheckOut_date = new Date(checkIn_date);
        minCheckOut_date.setDate(minCheckOut_date.getDate() + periodoMinimo);

        const minCheckOut_dateStr = minCheckOut_date.toISOString().substring(0, 10);
        checkOut.val(minCheckOut_dateStr);

    } else if (input === 'check_out') {
        const checkIn_date = new Date(checkIn.val());
        const checkOut_date = new Date(checkOut.val());

        const diffInTime = checkOut_date - checkIn_date;
        const diffInDays = diffInTime / (1000 * 3600 * 24);

        roomnights.val(diffInDays);
        valor.val((diffInDays * config.valorComissao) * aptos.val())
        previsao.val(calcularPrevisao(checkOut.val()));


        if (diffInDays < 4) {
            const minCheckOut_date = new Date(checkIn_date);
            minCheckOut_date.setDate(minCheckOut_date.getDate() + periodoMinimo);
            const minCheckOut_dateStr = minCheckOut_date.toISOString().substring(0, 10);
            checkOut.val(minCheckOut_dateStr);
        }
    }
}