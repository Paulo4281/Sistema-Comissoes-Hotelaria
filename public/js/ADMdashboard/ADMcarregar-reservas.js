$(document).ready(() => {
    $.ajax({
        url: 'ADMcarregar-reservas',
        type: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
        },
        success: function(response) {
            if (response.status == 1) {
                let form = $('#form-reservas-cadastradas');
                let table = $('<table>').addClass('table');
                let thead = $('<thead>')
                let tbody = $('<tbody>').css('--bs-table-bg', 'none').css('background', '#fff4e4');

                let reservas = response.reservas;

                let valorPagar = $('#input-valor-a-pagar');
                let valorPago = $('#input-valor-pago');
                let qtdeReservas = $('#input-qtde-reservas');

                let vaP = 0; // valor a pagar
                let vP = 0; // valor pago
                let qtdR = 0; // quantidade de reservas

                let thBackColor = '#31D2F2';
                let thColor = '#fff';
                let trBackColor = '#ffe7c4';
                let trSecBackColor = '#ffeacc';

                $('<tr>').css('position', 'sticky').css('top', '0').css('z-index', '999')
                .append($('<th>').text('Agente').css('background', `${thBackColor}`).css('color', `${thColor}`))
                .append($('<th>').text('Operadora').css('background', `${thBackColor}`).css('color', `${thColor}`))
                .append($('<th>').text('Titular').css('background', `${thBackColor}`).css('color', `${thColor}`))
                .append($('<th>').text('Sobrenome').css('background', `${thBackColor}`).css('color', `${thColor}`))
                .append($('<th>').text('Check-in').css('background', `${thBackColor}`).css('color', `${thColor}`))
                .append($('<th>').text('Check-out').css('background', `${thBackColor}`).css('color', `${thColor}`))
                .append($('<th>').text('Noites').css('background', `${thBackColor}`).css('color', `${thColor}`))
                .append($('<th>').text('Aptos').css('background', `${thBackColor}`).css('color', `${thColor}`))
                .append($('<th>').text('Valor').css('background', `${thBackColor}`).css('color', `${thColor}`))
                .append($('<th>').text('Previsão').css('background', `${thBackColor}`).css('color', `${thColor}`))
                .append($('<th>').text('').css('background', `${thBackColor}`).css('color', `${thColor}`))
                .appendTo(thead);

                agenteDetalhesBtn = [];

                reservas.forEach(reserva => {
                    if (reserva.status == 'pago') {
                        vP += Number(reserva.valor);
                    }
                    if (reserva.status == 'nao_pago') {
                        vaP += Number(reserva.valor);
                    
                    let row = $('<tr>')
                    .append($('<td>').addClass('py col-md-2').append($('<input>').addClass('form-control').css('background', `${trSecBackColor}`).prop('readonly', true).val(reserva.agente)))
                    .append($('<td>').addClass('').append($('<input>').addClass('form-control').css('background', `${trBackColor}`).prop('readonly', true).val(reserva.operadora)))
                    .append($('<td>').addClass('').append($('<input>').addClass('form-control').css('background', `${trSecBackColor}`).prop('readonly', true).val(reserva.titular)))
                    .append($('<td>').addClass('').append($('<input>').addClass('form-control').css('background', `${trBackColor}`).prop('readonly', true).val(reserva.sobrenome)))
                    .append($('<td>').addClass('').append($('<input>').addClass('form-control').css('background', `${trSecBackColor}`).prop('readonly', true).val(formatarData(reserva.check_in))))
                    .append($('<td>').addClass('').append($('<input>').addClass('form-control').css('background', `${trBackColor}`).prop('readonly', true).val(formatarData(reserva.check_out))))
                    .append($('<td>').addClass('').append($('<input>').addClass('form-control').css('background', `${trSecBackColor}`).prop('readonly', true).val(reserva.nights)))
                    .append($('<td>').addClass('').append($('<input>').addClass('form-control').css('background', `${trBackColor}`).prop('readonly', true).val(reserva.aptos)))
                    .append($('<td>').addClass('').append($('<input>').addClass('form-control').css('background', `${trSecBackColor}`).prop('readonly', true).val(formatarDinheiro(reserva.valor))))
                    .append($('<td>').addClass('').append($('<input>').addClass('form-control').css('background', `${trBackColor}`).prop('readonly', true).val(formatarData(reserva.previsao))))
                    if (!agenteDetalhesBtn.includes(reserva.idAgente)) {
                        agenteDetalhesBtn.push(reserva.idAgente);
                        $('<td>').append($('<input>').addClass('btn btn-info').attr('type', 'button').attr('id', `consultar-detalhes-agente_${reserva.idAgente}`).attr('onclick', 'verDetalhesPeloDashboard(this)').val('Detalhes')).appendTo(row);
                    }
                    row.appendTo(tbody);
                    qtdR++;
                    }
                })
                thead.appendTo(table);
                tbody.appendTo(table);
                table.appendTo(form);
                valorPagar.val(formatarDinheiro(vaP));
                valorPago.val(formatarDinheiro(vP));
                qtdeReservas.val(qtdR);
            }
        }
    })
})