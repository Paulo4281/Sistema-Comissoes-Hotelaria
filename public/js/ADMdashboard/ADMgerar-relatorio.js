function ADMGerarRelatorio() {
    $.ajax({
        url: 'ADMgerar-relatorio',
        type: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
        },
        success: function(response) {
            if (response.status == 1) {
                let modal = new bootstrap.Modal($('#modal-gerar-relatorio'));
                $('#modal-gerar-relatorio').fadeIn();
                modal.show();

                let periodoEntre = $('#periodo-entre');
                let periodoAte = $('#periodo-ate');
                let prevPagText = $('#prev-pagamento-text');
            
                periodoEntre.on('change', () => {
                    prevPagText.text(`Previsão de pagamento: entre ${formatarData(periodoEntre.val())} até ${periodoAte.val() != null ? formatarData(periodoAte.val()) : periodoAte.val('dd-mm-yyy')}`);
                    periodoAte.prop('disabled', false);
                })
            
                periodoAte.on('change', () => {
                    prevPagText.text(`Previsão de pagamento: entre ${periodoEntre.val() != null ? formatarData(periodoEntre.val()) : periodoEntre.val('dd-mm-yyy')} até ${formatarData(periodoAte.val())}`);
                });
            }

            return false;
        }
    })
}

function relatorio() {

    let periodoEntre = $('#periodo-entre');
    let periodoAte = $('#periodo-ate');
    let errorDataModal = $('#error-data-modal');

    if (periodoEntre.val() == '' || periodoAte.val() == '') {
        errorDataModal.modal('show');
        return false;
    }

    $.ajax({
        url: 'ADMobter-relatorio',
        type: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            periodoEntre: periodoEntre.val(),
            periodoAte: periodoAte.val(),
        },
        success: function(response) {
            if (response.status == 1) {
                
                $('#modal-gerar-relatorio').fadeOut();
                $('#modal-gerar-relatorio').hide();
                
                $('.modal-backdrop').fadeOut();
                let modalRelatorio = new bootstrap.Modal($('#modal-visualizar-relatorio'));
                $('#modal-visualizar-relatorio').fadeIn();
                modalRelatorio.show();

                $('#btn-close-visualizar-relatorio').on('click', () => location.reload());

                let modalTitle = $('#modal-title-relatorio');
                let tbody = $('#tbody-visualizar-relatorio');
                let agentes = [];




                response.dadosReserva.forEach(agente => {

                    let agenteData = response.dadosAgentes.find(a => a.id === agente.id_agente);

                        let agenteIndex = agentes.findIndex(element => element.agente === agente.agente);
                        if (agenteIndex === -1) {
                            agentes.push({ id: agenteData.id, agente: agente.agente, pix: agenteData.pix, valorTotal: Number(agente.valor) });
                        } else {
                            if (agente.status == 'nao_pago') {
                                agentes[agenteIndex].valorTotal += Number(agente.valor);
                            }
                        }


                });

                let valorTotalTodosAgentes = 0;

                let relatorioImprimirGeralBtn = $('#relatorio-imprimir-geral');


                tbody.empty();
                agentes.forEach(agente => {
                    $('<tr>')
                        .append($('<td>').append($('<span>').text(agente.agente)))
                        .append($('<td>').append($('<span>').text(agente.pix)))
                        .append($('<td>').append($('<span>').html(`${textoDestaque(`${formatarDinheiro(agente.valorTotal)}`, 700)}`)))
                        .append($('<td>').append($('<input>').addClass('btn btn-info').attr('type', 'button').attr('id', `detalhes_${agente.id}_${periodoEntre.val()}_${periodoAte.val()}`).attr('onclick', 'verDetalhes(this)').val('Detalhes')))
                        .appendTo(tbody);
                        valorTotalTodosAgentes += Number(agente.valorTotal);
                });
                modalTitle.html(`Relatório de ${formatarData(periodoEntre.val())} até ${formatarData(periodoAte.val())} || ${textoDestaque(`Valor total: ${formatarDinheiro(valorTotalTodosAgentes)}`, 800)}`);

                relatorioImprimirGeralBtn.on('click', () => {
                    if (valorTotalTodosAgentes == '' || agentes == '') {
                        return false;
                    }
                    imprimirRelatorioTodosAgentes(valorTotalTodosAgentes, agentes);
                });

            } else if (response.status == 2) {
                let errorModalPrevisao = $('#error-previsao-modal');
                errorModalPrevisao.modal('show');
                return false;
            }

            return false;
        }
    });
}

function verDetalhes(id) {

    let agenteId = id.id.split("_")[1];
    let periodoEntre = id.id.split("_")[2];
    let periodoAte = id.id.split("_")[3];

    if (agenteId == '') {
        return false;
    } 

    $.ajax({
        url: 'ADMver-detalhes',
        type: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            agenteId: agenteId,
            periodoEntre: periodoEntre,
            periodoAte: periodoAte,
        },
        success: function(response) {
            if (response.status == 1) {
                let modalDetalhes = new bootstrap.Modal($('#modal-visualizar-detalhes'));
                $('#modal-visualizar-detalhes').fadeIn();
                modalDetalhes.show();

                $('.modal-backdrop').fadeOut();

                let modalRelatorio = $('#modal-visualizar-relatorio');
                let imprimirRelatorioBtn = $('#imprimir-relatorio-individual');

                let modalTitle = $('#modal-title-detalhes');

                let btnBack = $('#modal-voltar');
                modalRelatorio.hide();

                let tbodyAgente = $('#tbody-visualizar-detalhes-agente');
                let tbodyAgencia = $('#tbody-visualizar-detalhes-agencia');
                let tbodyReservas = $('#tbody-visualizar-detalhes-reservas');
                let tbodyReservasPagas = $('#tbody-visualizar-detalhes-reservas-pagas');         

                btnBack.on('click', () => {
                    $('#modal-visualizar-detalhes').fadeOut();
                    modalDetalhes.hide();
                    $('#modal-visualizar-relatorio').fadeIn();
                    modalRelatorio.show();
                });

                let dadosAgente = response.dadosAgente;
                let dadosReserva = response.dadosReserva;
                let dadosReservaPaga = response.dadosReservaPaga;

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
                
                let valorAPagarText = $('#valor-a-pagar');
                let valorPagoText = $('#valor-pago');

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
                        .append($('<td>').append('<span>').text(reserva.data_pagamento == null ? reserva.data_pagamento = '..' : reserva.data_pagamento = formatarData(reserva.data_pagamento)))
                        .append($('<td>').append($('<span>').text(reserva.adm_alteracao == null ? reserva.adm_alteracao = '..' : reserva.adm_alteracao = reserva.adm_alteracao)))
                        .append($('<td>').append($('<input>').addClass('btn btn-primary').attr('type', 'button').attr('id', `pagar-reserva_${reserva.id_reserva}`).attr('onclick', 'pagarReserva(this)').val('Pagar')))
                        )   
                        
                        valorAPagar += Number(reserva.valor);
                        valorAPagarText.html(`${textoDestaque(`Valor total a pagar: ${formatarDinheiro(valorAPagar)}`, 800)}`);
                        

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
                        
                        let verPagas = $('#modal-ver-pagas');
                        
                        verPagas.on('click', (event) => {
                            if (event.currentTarget.checked == true) {
                                tbodyReservasPagas.show();
                            } else {
                                tbodyReservasPagas.hide();
                            }
                        });
                        

            } 
            else if (response.status == 0) {
                return false;
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

function verDetalhesPeloDashboard(id) {

    let agenteId = id.id.split("_")[1];

    
    if (agenteId == '') {
        return false;
    }

}

function imprimirRelatorioTodosAgentes(vTotal, agnts) {

    let valorTotal = vTotal;
    let agentes = agnts;

    if (valorTotal == '' || agentes == '') {
        return false;
    }

    $.ajax({
        url: 'ADMimprimir-relatorio-geral',
        type: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
        },
        success: function(response) {
            if (response.status == 1) {
                valorTotal = JSON.stringify(valorTotal);
                agentes = JSON.stringify(agentes);

                window.open(`imprimir-relatorio-geral/?agentes=${agentes}&valorTotal=${valorTotal}`);
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