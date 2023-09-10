$(document).ready(() => {

    let body = $('body');
    let operadora = $('#input-operadora');
    let titular = $('#input-titular');
    let sobrenome = $('#input-sobrenome');
    let checkIn = $('#input-check-in');
    let checkOut = $('#input-check-out');
    let aptos = $('#input-numero-aptos');
    let inserirReservaBtn = $('#input-inserir-reserva');

    

    body.on("mouseover", () => {
        if (operadora.val() == '' && titular.val() == '' && sobrenome.val() == '' && checkIn.val() == '' && checkOut.val() == '') {
            titular.prop('disabled', true);
            sobrenome.prop('disabled', true);
            checkIn.prop('disabled', true);
            checkOut.prop('disabled', true);
            aptos.prop('disabled', true);
            inserirReservaBtn.prop('disabled', true);
        }
    });

    operadora.on("input", () => {
            titular.prop('disabled', false);
    });

    titular.on("input", () => {
        sobrenome.prop('disabled', false);
    });

    sobrenome.on("input", () => {
        checkIn.prop('disabled', false);
    });

    checkIn.on("change", () => {
        checkOut.prop('disabled', false);
        aptos.prop('disabled', false);
        inserirReservaBtn.removeClass('btn-secondary');
        inserirReservaBtn.addClass('btn-primary');
        inserirReservaBtn.prop('disabled', false);
    });

});

$(document).ready(() => {

    let checkIn = $('#input-check-in');
    let checkOut = $('#input-check-out');
    
    let checkIn_date;
    let checkOut_date;

    let periodoMinimo = config.periodoMinimo;
    
    checkIn.on('change', () => {
        checkIn.val() !== '' ? checkOut.prop('disabled', false) : checkOut.prop('disabled', true);
        
        const checkIn_date = new Date(checkIn.val());
        checkIn_date.setDate(checkIn_date.getDate() + periodoMinimo);
        
        const checkOut_date = checkIn_date.toISOString().substring(0, 10);
        checkOut.val(checkOut_date);
    });
    
    checkOut.on('change', () => {
        const checkIn_date = new Date(checkIn.val());
        checkIn_date.setDate(checkIn_date.getDate() + periodoMinimo);
        
        const checkOut_date = new Date(checkOut.val());
        
        if (checkOut_date < checkIn_date) {
            checkOut.val(checkIn_date.toISOString().substring(0, 10));
        }
    });
    

});

function inserirReserva() {

    let dataPeriodoCorte = new Date(config['periodo-corte']);
    let modalPeriodoCorte = $('#modal-error-periodo-corte');
    let modalPeriodoCorteText = $('#periodo-corte-text');

    let resumoReservaModal = $('#modal-resumo-reserva');
    let resumoOperadora = $('#resumo-reserva-operadora');
    let resumoTitular = $('#resumo-reserva-titular');
    let resumoSobrenome = $('#resumo-reserva-sobrenome');
    let resumoCheckin = $('#resumo-reserva-check-in');
    let resumoCheckout = $('#resumo-reserva-check-out');
    let resumoAptos = ($('#resumo-reserva-aptos'));
    let resumoValor = $('#resumo-reserva-valor');
    let resumoPrevisao = $('#resumo-reserva-previsao');

    let operadora = $('#input-operadora').val();
    let titular = $('#input-titular').val();
    let sobrenome = $('#input-sobrenome').val();
    let checkIn = $('#input-check-in').val();
    let checkOut = $('#input-check-out').val();
    let aptos = $('#input-numero-aptos').val();
    let valor;
    let previsao;

    let dataCheckIn = new Date(checkIn);
    let dataCheckOut = new Date(checkOut);
    let diferencaEmMilissegundos = dataCheckOut - dataCheckIn;
    let diferencaEmDias = diferencaEmMilissegundos / (1000 * 60 * 60 * 24);

    if (dataCheckIn < dataPeriodoCorte || dataCheckOut < dataPeriodoCorte) {
        modalPeriodoCorteText.text(`Você deve escolher uma data acima de ${formatarData(dataPeriodoCorte)}`);
        modalPeriodoCorte.modal('show');
        return false;
    }

    let roomnights = diferencaEmDias;
 
    let dataPrevisao = new Date(dataCheckOut);
    dataPrevisao.setDate(dataPrevisao.getDate() + 15);

    previsao = dataPrevisao.toISOString().substring(0, 10);
    valor = ((config.valorComissao * diferencaEmDias) * aptos);

    if (operadora == '' || titular == '' || sobrenome == '' || checkIn == '' || checkOut == '' || aptos == '' ) {
        return false;
    }

    if (checkIn > checkOut || checkIn == checkOut) {
        return false;
    }

    resumoOperadora.text(operadora);
    resumoTitular.text(titular);
    resumoSobrenome.text(sobrenome);
    resumoCheckin.text(formatarData(checkIn));
    resumoCheckout.text(formatarData(checkOut));
    resumoAptos.text(aptos);
    resumoPrevisao.text(formatarData(previsao));
    resumoValor.html(textoDestaque(formatarDinheiro(valor), 800));

    resumoReservaModal.modal('show');

    $('#resumo-reserva-cancelar').on('click', () => {
        resumoReservaModal.modal('hide');
        location.reload();
        return false;
    });

    $('#resumo-reserva-confirmar').on('click', () => {
        resumoReservaModal.modal('hide');
        $.ajax({
            url: 'inserir-reserva',
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                operadora: operadora,
                titular: titular,
                sobrenome: sobrenome,
                checkIn: checkIn,
                checkOut: checkOut,
                roomnights: roomnights,
                aptos: aptos,
                valor: valor,
                previsao: previsao,
            },
            success: function(response) {
                if (response.status == 1) {
                    let modalSuccess = $('#modal-reserva-inserida');
                    modalSuccess.modal('show');
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                    return true;
                }
                return false;
            }
        });
    });
}