function verDetalhesPeloDashboard(id) {

    var agenteId = id.id.split("_")[1];

    if (agenteId == '') {
        return false;
    }

    $.ajax({
        url: 'ADMobter-detalhes-dashboard',
        type: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            agenteId: agenteId,
        },
        success: function(response) {
            if (response.status == 1) {
                let modalDetalhes = new bootstrap.Modal($('#modal-visualizar-relatorio-pelo-dashboard'));
                $('#modal-visualizar-relatorio-pelo-dashboard').fadeIn();
                modalDetalhes.show();

                
                $('.modal-backdrop').fadeOut();
                
                let modalRelatorio = $('#modal-visualizar-relatorio-pelo-dashboard');
                let imprimirRelatorioBtn = $('#imprimir-relatorio-pelo-dashboard');
                
                let modalTitle = $('#modal-title-visualizar-relatorio-pelo-dashboard');
                
                // modalRelatorio.hide();
                
                let tbodyAgente = $('#tbody-visualizar-relatorio-pelo-dashboard-agente');
                let tbodyAgencia = $('#tbody-visualizar-relatorio-pelo-dashboard-agencia');
                let tbodyReservas = $('#tbody-visualizar-relatorio-pelo-dashboard-reservas');
                let tbodyReservasPagas = $('#tbody-visualizar-relatorio-pelo-dashboard-reservas-pagas');         

                let dadosAgente = response.dadosAgente;
                let dadosReserva = response.dadosReserva;
                let dadosReservaPaga = response.dadosReservaPaga;
                
                let periodoEntreId = $('#data-entre-relatorio-pelo-dashboard');
                let periodoAteId = $('#data-ate-relatorio-pelo-dashboard');

                periodoEntreId.on('change', function() {
                    alteraPrevisaoDashboard(this, agenteId);
                })

                periodoAteId.on('change', function() {
                    alteraPrevisaoDashboard(this, agenteId);
                })

                let closeRelatorioBtn = $('#btn-close-relatorio-pelo-dashboard');

                closeRelatorioBtn.on('click', () => {
                    location.reload();
                });

                

                modalTitle.text(`Detalhes de ${dadosAgente[0].nome}` + ' ' + `${dadosAgente[0].sobrenome}`);

                
                
                dadosAgente.forEach(agente => {
                    tbodyAgente.empty();
                    tbodyAgente.append($('<tr>').addClass('table-primary')
                    .append($('<td>').append('<span>').text(`${agente.nome}` + ' ' + `${agente.sobrenome}`))
                    .append($('<td>').append('<span>').text(formatarData(agente.dataNascimento)))
                    .append($('<td>').append('<span>').text(agente.genero))
                    .append($('<td>').append('<span>').text(agente.cpf))
                    .append($('<td>').append('<span>').text(agente.email))
                    .append($('<td>').append('<span>').text(agente.whatsapp))
                    .append($('<td>').append('<span>').text(agente.pix))
                    )
                });

                dadosAgente.forEach(agencia => {
                    tbodyAgencia.empty();
                    tbodyAgencia.append($('<tr>').addClass('table-info')
                    .append($('<td>').append('<span>').text(agencia.agencia))
                    .append($('<td>').append('<span>').text(agencia.estado))
                    .append($('<td>').append('<span>').text(agencia.cidade))
                    .append($('<td>').append('<span>').text(agencia.bairro))
                    .append($('<td>').append('<span>').text(agencia.rua))
                    )
                });

                let valorAPagar = 0;
                let valorPago = 0;
                
                let valorAPagarText = $('#valor-a-pagar-dashboard');
                let valorPagoText = $('#valor-pago-dashboard');

                valorAPagarText.empty();
                valorPagoText.empty();
                
                tbodyReservas.empty();
                dadosReserva.forEach(reserva => {
                        tbodyReservas.append($('<tr>').addClass('table-primary')
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
                        

                    })
                
                imprimirRelatorioBtn.attr('onclick', `imprimirRelatorioIndividual(${dadosAgente[0].id}, ${valorAPagar})`);



                tbodyReservasPagas.empty();
                dadosReservaPaga.forEach(reserva => {
                    tbodyReservasPagas.append(
                        $('<tr>').addClass('table')
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


                        
                        let verPagas = $('#ver-pagas-relatorio-pelo-dashboard');
                        
                        verPagas.on('click', (event) => {
                            if (event.currentTarget.checked == true) {
                                tbodyReservasPagas.show();
                            } else {
                                tbodyReservasPagas.hide();
                            }
                        });
                        

            } 
            return false;
        }
    })

}

function alteraPrevisaoDashboard(data, idAgente) {

    let agenteId = idAgente;
    let errorPrevisaoModal = $('#error-previsao-modal');

    if (data.id == 'data-entre-relatorio-pelo-dashboard') {
        periodoEntre = $(data).val();
        periodoAte = $(data)[0].nextElementSibling.id;
        periodoAte = $(`#${periodoAte}`).val();
    } else {
        periodoAte = $(data).val();
        periodoEntre = $(data)[0].previousElementSibling.id;
        periodoEntre = $(`#${periodoEntre}`).val();
    }

    if (periodoEntre == '' && periodoAte == '') {
        return false;
    }

    $.ajax({
        url: 'ADMatualizar-previsao-dashboard',
        type: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            agenteId: agenteId,
            periodoEntre: periodoEntre,
            periodoAte: periodoAte,
        },
        success: function(response) {
            if (response.status == 1) {

                // let dadosAgente = response.dadosAgente;
                // let dadosReservaPaga = response.dadosReservaPaga;

                let dadosReserva = response.dadosReserva;
                let dadosReservaForaPrevisao = response.dadosReservaForaPrevisao;

                let imprimirRelatorioBtn = $('#imprimir-relatorio-pelo-dashboard');

                if (dadosReserva == '') {
                    errorPrevisaoModal.modal('show');
                    imprimirRelatorioBtn.removeClass('btn btn-primary');
                    imprimirRelatorioBtn.addClass('btn btn-secondary');
                    imprimirRelatorioBtn.attr('onclick', `none`);
                } else {
                    imprimirRelatorioBtn.removeClass('btn btn-secondary')
                    imprimirRelatorioBtn.addClass('btn btn-primary');
                }

                let tbodyReservas = $('#tbody-visualizar-relatorio-pelo-dashboard-reservas');

                let valorAPagar = 0;
                
                let valorAPagarText = $('#valor-a-pagar-dashboard');

                valorAPagarText.empty();

                tbodyReservas.empty();
                dadosReserva.forEach(reserva => {
                        tbodyReservas.append($('<tr>').addClass('table-primary')
                        .append($('<td>').append('<span>').text(`${reserva.titular}` + ' ' + `${reserva.sobrenome}`))
                        .append($('<td>').append('<span>').text(reserva.check_in))
                        .append($('<td>').append('<span>').text(reserva.check_out))
                        .append($('<td>').append('<span>').text(reserva.roomnights))
                        .append($('<td>').append('<span>').text(reserva.aptos))
                        .append($('<td>').append('<span>').text(formatarDinheiro(reserva.valor)))
                        .append($('<td>').append('<span>').text(formatarData(reserva.previsao)))

                        )                        
                        valorAPagar += Number(reserva.valor);
                        valorAPagarText.text(`Valor total: ${formatarDinheiro(valorAPagar)}`);
                        
                        imprimirRelatorioBtn.attr('onclick', `imprimirRelatorioIndividual(${reserva.id_agente}, ${valorAPagar})`);
                    })

                    let linhasReservasForaPrevisao = [];

                    dadosReservaForaPrevisao.forEach(reserva => {
                        let linhaReserva = $('<tr>').addClass('table-primary')
                            .append($('<td>').append($('<span>').text(`${reserva.titular} ${reserva.sobrenome}`)))
                            .append($('<td>').append($('<span>').text(reserva.check_in)))
                            .append($('<td>').append($('<span>').text(reserva.check_out)))
                            .append($('<td>').append($('<span>').text(reserva.roomnights)))
                            .append($('<td>').append($('<span>').text(reserva.aptos)))
                            .append($('<td>').append($('<span>').text(formatarDinheiro(reserva.valor))))
                            .append($('<td>').append($('<span>').text(formatarData(reserva.previsao))))
                            .hide();
                        
                        linhasReservasForaPrevisao.push(linhaReserva);
                    });

                    tbodyReservas.append(linhasReservasForaPrevisao);

                    let verForaPrevisao = $('#ver-fora-previsao-relatorio-pelo-dashboard');

                    verForaPrevisao.on('click', (event) => {
                        if (event.currentTarget.checked) {
                            linhasReservasForaPrevisao.forEach(linha => linha.show());
                        } else {
                            linhasReservasForaPrevisao.forEach(linha => linha.hide());
                        }
                    });

            }

            return false;
        }
    })

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