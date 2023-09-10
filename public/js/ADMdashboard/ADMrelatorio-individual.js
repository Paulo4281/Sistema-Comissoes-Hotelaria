$(document).ready(() => {

    let agente = $('#relatorio-agente');
    let pix = $('#relatorio-pix');
    let valor = $('#relatorio-valor');

    let queryData = window.location.search;
    let params = new URLSearchParams(queryData);

    let agenteParam = params.get('agente');
    let pixParam = params.get('pix');
    let valorParam = params.get('valor');

    agente.text(agenteParam);
    pix.text(pixParam);
    valor.text(`R$ ${valorParam}`);

    window.print();

    function closePage() {
        window.close();
    }

    if (window.matchMedia) {
        let mediaQueryList = window.matchMedia('print');
        window.onafterprint = closePage;
    }

})