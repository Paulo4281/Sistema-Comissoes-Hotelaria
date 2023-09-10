    
    // ESTE É O PAÍNEL DE CONTROLE NO LADO DO SERVIDOR //
    
    // SCRIPT PARA ATIVAR OS TOOLTIPS //

    $(document).ready(() => {
        $('[data-bs-toggle="tooltip"]').tooltip();
    });

    // ** //

    // SCRIPT PARA ATIVAR OS TOOLTIPS SOMENTE QUANDO ESTIVER EM 'HOVER' OU EM 'FOCUS' //

    $(document).ready(() => {

        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl, {
                    trigger: 'hover focus'
                });
            });

            
    });

    // ** //

    // SCRIPT PARA TRANSFORMAR A DATA NO FORMATO 'DD-MM-YYYY' //

    function formatarData(data) {
        let dataFormatada = dayjs(data);

        return dataFormatada.format('DD-MM-YYYY');
    }

    // ** //

    // SCRIPT PARA COLOCAR 'R$' EM VALORES //

    function formatarDinheiro(valor) {
        return `R$ ${valor}`;
    }

    // ** //
    
    // SCRIPT PARA CARREGAR O REGULAMENTO //
    
    function verRegulamento() {
        let modalRegulamento = $('#regulamento-modal');
        modalRegulamento.modal('show');
    }

    // ** //

    // SCRIPT PARA APLICAR TEMA ESCURO //
    
    function toggleTheme() {

        $.ajax({
            url: 'toggle-theme',
            type: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
            },
            success: function(response) {
                if (response.status == 1) {
                    location.reload();
                }
    
                return false;
            }
        })
    }

    // ** //

    // SCRIPT PARA DESTACAR UM TEXTO //

    function textoDestaque(texto, weight) {
        return `<span style="font-weight: ${weight}">${texto}</span>`;
    }

    // ** //

    // SCRIPT PARA CARREGAR REGULAMENTO //

    $(document).ready(() => {
        
        $('.regulamento-body').html(config.regulamentoBody);

    })

    // ** //

    // VERSAO DO CODIGO //

    $(document).ready(() => {

        $('.versao-codigo').text('Versão:' + ' ' + config.versao);

    });

    // ** //

    // AUTORIA //

    $(document).ready(() => {

        $('.desenvolvido-por').html(config.desenvolvidoPor);

    });

    // ** //
    
    // LOAD IMAGENS //

    $(document).ready(() => {

        $('.login-background').attr('src', config.loginBackground).attr('alt', '');

        $('.cadastro-background').attr('src', config.cadastroBackground).attr('alt', '');

        $('.logo-branco').attr('src', config.logoBranco).attr('alt', '');

        $('.logo-cor').attr('src', config.logoCor).attr('alt', '');

    });
    
    // ** //

    // SOBRE CONFIG //

    function sobre() {
        let modalSobre = $('#sobre-modal');
        modalSobre.modal('show');

        $('.sobre-body').html(config.sobre);
    }

    // ** //

    // LINKS REDES //

    function instagram() {
        window.open('https://www.instagram.com/paulo_wellingtonn/?next=%2F', '_blank');
        return false;
    }

    function github() {
        window.open('https://github.com/Paulo4281', '_blank');
        return false;
    }

    function linkedin() {
        window.open('https://www.linkedin.com/in/paulo-oliveira-b75b30149/', '_blank');
        return false;
    }
    // ** //