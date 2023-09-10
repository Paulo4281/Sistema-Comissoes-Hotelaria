$(document).ready(() => {

    let queryData = window.location.search;
    let params = new URLSearchParams(queryData);

    let agentes = params.get('agentes');
    let valorTotal = params.get('valorTotal');

    let agentesArray = JSON.parse(agentes);

    let tbody = $('#tbody-relatorio-geral');
    let valorTotalText= $('#text-valor-total');

    console.log(agentesArray);

    tbody.empty();
    valorTotalText.empty();

    agentesArray.forEach(agente => {
        $('<tr>')
        .append($('<td>').text(agente.agente))
        .append($('<td>').text(agente.pix))
        .append($('<td>').text(`R$ ${agente.valorTotal}`))
        .appendTo(tbody)
    });

    valorTotalText.text(`Valor Total: R$ ${valorTotal}`).addClass('text-center').appendTo(tbody);

    window.print();

    function closePage() {
        window.close();
    }

    if (window.matchMedia) {
        let mediaQueryList = window.matchMedia('print');
        window.onafterprint = closePage;
    }

});