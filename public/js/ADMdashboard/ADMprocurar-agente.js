function consultarAgente() {
    let modalProcurarAgente = $('#modal-procurar-agente');
    modalProcurarAgente.modal('show');
    $('#consultar-agente-imprimir-relatorio').hide();
    $('#form-check-consultar-agente-ver-pagas').hide();

    $.ajax({
        url: 'ADMprocurar-agente',
        type: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
        },
        success: function(response) {
            console.log(response);
            if (response.status == 1) {
                let dadosAgente = response.dados;
                let selectNomes = $('#select-consultar-agente');

                dadosAgente.forEach(agente => {
                    let option = $('<option>').addClass('text-uppercase').val(agente.id).text(agente.nome);
                    selectNomes.append(option);
                });


                $('#select-consultar-agente').on('change', function() {
                    let agenteId = $(this).val();

                    if (agenteId == '') {
                        return false;
                    }

                    $.ajax({
                        url: 'ADMprocurar-agente-info',
                        type: 'POST',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            agenteId: agenteId,
                        },
                        success: function(response) {
                            console.log(response);
                            if (response.status == 1) {

                                
                                $('#consultar-agente-imprimir-relatorio').show();
                                $('#form-check-consultar-agente-ver-pagas').show();

                                let dadosAgente = response.dadosAgente;
                                let dadosReserva = response.dadosReserva;
                                let dadosReservaPaga = response.dadosReservaPaga;

                                let divAgenteInfo = $('#div-consultar-agente-info');
                                let tbodyAgenteInfo = $('#tbody-consultar-agente');
                                let tbodyAgenciaInfo = $('#tbody-consultar-agente-agencia');
                                let tbodyAgenteReservas = $('#tbody-consultar-agente-reservas');
                                let tbodyAgenteReservasPagas = $('#tbody-consultar-agente-reservas-pagas');

                                let imprimirRelatorioBtn = $('#consultar-agente-imprimir-relatorio');

                                let verPagas = $('#consultar-agente-ver-pagas');

                                dadosAgente.forEach(agente => {
                                    tbodyAgenteInfo.empty();
                                    tbodyAgenteInfo.append($('<tr>').addClass('table-primary')
                                    .append($('<td>').append($('<span>').text(`${agente.nome}` + ' ' + `${agente.sobrenome}`)))
                                    .append($('<td>').append('<span>').text(formatarData(agente.dataNascimento)))
                                    .append($('<td>').append('<span>').text(agente.genero))
                                    .append($('<td>').append('<span>').text(agente.cpf))
                                    .append($('<td>').append('<span>').text(agente.email))
                                    .append($('<td>').append('<span>').text(agente.whatsapp))
                                    .append($('<td>').append('<span>').text(agente.pix))
                                    )
                                });

                                dadosAgente.forEach(agencia => {
                                    tbodyAgenciaInfo.empty();
                                    tbodyAgenciaInfo.append($('<tr>').addClass('table-info')
                                    .append($('<td>').append('<span>').text(agencia.agencia))
                                    .append($('<td>').append('<span>').text(agencia.estado))
                                    .append($('<td>').append('<span>').text(agencia.cidade))
                                    .append($('<td>').append('<span>').text(agencia.bairro))
                                    .append($('<td>').append('<span>').text(agencia.rua))
                                    )
                                });

                                let valorAPagar = 0;
                                let valorPago = 0;

                                let valorAPagarText = $('#consultar-agente-valor-a-pagar');
                                let valorPagoText = $('#consultar-agente-valor-pago');

                                valorAPagarText.empty();
                                valorPagoText.empty();

                                tbodyAgenteReservas.empty();
                                dadosReserva.forEach(reserva => {
                                    tbodyAgenteReservas.append($('<tr>').addClass('table-primary')
                                    .append($('<td>').append('<span>').text(`${reserva.titular}` + ' ' + `${reserva.sobrenome}`))
                                    .append($('<td>').append('<span>').text(formatarData(reserva.check_in)))
                                    .append($('<td>').append('<span>').text(formatarData(reserva.check_out)))
                                    .append($('<td>').append('<span>').text(reserva.roomnights))
                                    .append($('<td>').append('<span>').text(reserva.aptos))
                                    .append($('<td>').append('<span>').text(formatarDinheiro(reserva.valor)))
                                    .append($('<td>').append('<span>').text(formatarData(reserva.previsao)))
                                    .append($('<td>').append($('<span>').text(reserva.adm_alteracao == null ? reserva.adm_alteracao = '..' : reserva.adm_alteracao = reserva.adm_alteracao)))
                                    .append($('<td>').append('<span>').text(reserva.data_pagamento == null ? reserva.data_pagamento = '..' : reserva.data_pagamento = formatarData(reserva.data_pagamento)))
                                    .append($('<td>').append($('<input>').addClass('btn btn-primary').attr('type', 'button').attr('id', `pagar-reserva_${reserva.id_reserva}`).attr('onclick', 'pagarReserva(this)').val('Pagar')))
                                    )

                                    valorAPagar += Number(reserva.valor);
                                    valorAPagarText.html(`Valor total a pagar: ${textoDestaque(`${formatarDinheiro(valorAPagar)}`, 800)}`);

                                });

                                tbodyAgenteReservasPagas.empty();
                                dadosReservaPaga.forEach(reserva => {
                                    tbodyAgenteReservasPagas.append($('<tr>').addClass('table')
                                    .append($('<td>').append($('<span>').text(`${reserva.titular} ${reserva.sobrenome}`)))
                                    .append($('<td>').append($('<span>').text(formatarData(reserva.check_in))))
                                    .append($('<td>').append($('<span>').text(formatarData(reserva.check_out))))
                                    .append($('<td>').append($('<span>').text(reserva.roomnights)))
                                    .append($('<td>').append($('<span>').text(reserva.aptos)))
                                    .append($('<td>').append($('<span>').text(formatarDinheiro(reserva.valor))))
                                    .append($('<td>').append($('<span>').text(formatarData(reserva.previsao))))
                                    .append($('<td>').append($('<span>').text(formatarData(reserva.data_pagamento))))
                                    .append($('<td>').append($('<span>').text(reserva.adm_alteracao == null ? reserva.adm_alteracao = '..' : reserva.adm_alteracao = reserva.adm_alteracao)))
                                    .append($('<td>').append($('<input>').addClass('btn btn-secondary').attr('type', 'button').attr('id', `desfazer-pagamento_${reserva.id_reserva}`).attr('onclick', 'desfazerPagamento(this)').val('Desfazer')))
                                    ).hide();

                                    valorPago += Number(reserva.valor);
                                    valorPagoText.text(`Valor total pago: ${formatarDinheiro(valorPago)}`);
                                });

                                imprimirRelatorioBtn.attr('onclick', `imprimirRelatorioIndividual(${dadosAgente[0].id}, ${valorAPagar})`);

                                verPagas.on('click', (event) => {
                                    if (event.currentTarget.checked == true) {
                                        tbodyAgenteReservasPagas.show();
                                    } else {
                                        tbodyAgenteReservasPagas.hide();
                                    }
                                });

                                divAgenteInfo.removeClass('d-none');
                                divAgenteInfo.addClass('d-block');

                            }
                            return false;
                        }
                    });
                });

            }
            return false;
        }
    });
}

function pagarReserva(id) {

    let reservaId = id.id.split("_")[1];

    if (reservaId == '') {
        return false;
    }

    $.ajax({
        url: 'ADMpagar-reserva',
        type: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            reservaId: reservaId,
        },
        success: function(response) {
            if (response.status == 1) {
                let pagarModal = $('#pagar-modal');
                pagarModal.modal('show');
                $(id).removeClass('btn-primary').addClass('btn-secondary').attr('id', `defazer-pagamento_${reservaId}`).attr('onclick', 'desfazerPagamento(this)').val('Desfazer');
            }

            return false;
        }
    })

}

function desfazerPagamento(id) {

    let reservaId = id.id.split("_")[1];

    if (reservaId == '') {
        return false;
    }

    $.ajax({
        url: 'ADMdesfazer-pagar-reserva',
        type: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            reservaId: reservaId,
        },
        success: function(response) {
            if (response.status == 1) {
                let desfazerModal = $('#desfazer-modal');
                desfazerModal.modal('show');
                $(id).removeClass('btn-secondary').addClass('btn-primary').attr('id', `pagar-reserva_${reservaId}`).attr('onclick', 'pagarReserva(this)').val('Pagar');
            }
            return false;
        }
    })

}

function imprimirRelatorioIndividual(id, valor) {

    let agenteId = id;
    let valorTotal = valor;

    $.ajax({
        url: 'ADMimprimir-relatorio-individual',
        type: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            agenteId: agenteId,
        },
        success: function(response) {
            if (response.status == 1) {
                $.ajax({
                    url: 'ADMrelatorio-individual',
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        agente: `${response.dadosAgente[0].nome}` + ' ' + `${response.dadosAgente[0].sobrenome}`,
                        pix: response.dadosAgente[0].pix,
                        valor: valorTotal,
                    },
                    success: function(response) {
                        if (response.status == 1) {
                            let agente = response.agente;
                            let pix = response.pix;
                            let valor = response.valor;
                            window.open(`imprimir-relatorio-individual/?agente=${agente}&pix=${pix}&valor=${valor}`, '_blank');
                            
                        }

                        return false;
                    }
                })
            }

            return false;
        }
    })

}