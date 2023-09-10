<?php 

    return [

        // ESTE É O PAÍNEL DE CONTROLE NO LADO DO SERVIDOR //
        
        /* LOGIN CONFIG */

        'limiteTentativasLogin' => 5,
        'limiteTentativasLoginSuperADM' => 5,

        /* ** */

        /* DASHBOARD CONFIG */

        'periodoMinimo' => 4,
        'valorComissao' => 10,
        'previsao' => 15,
        'periodo-corte' => '2023-05-01', /* (FORMAT) YYYY-MM-DD */
        
        /* ** */

        /* IMAGENS CONFIG */

        'loginBackground' => './img/background_login.jpg',
        'cadastroBackground' => './img/background_cadastro.jpg',
        'logoBranco' => './img/logo_branco.png',
        'logoCor' => './img/logo_cor.png',

        /* ** */

        /* AUTORIA CONFIG */

        'desenvolvidoPor' => 'Desenvolvido Por Paulo Wellington&nbsp;',

        /* ** */

        /* NOTAS VERSAO CODIGO CONFIG */

        'versao' => '2.0.0',

        /* ** */

        /* REGULAMENTO CONFIG */

        'regulamentoBody' => 
        '
        <h2>Gratidão!</h2>
        <p>Sou um desenvolvedor back-end apaixonado por desafios. O desafio de construir este sistema foi incrível para mim. Sinta-se a vontade para me dar sugestões através das minhas redes sociais.</p>
        <p>Acesse também as minha redes e saiba um pouco mais sobre o meu trabalho.</p>
        <br>
        <div class="d-flex justify-content-center align-items-center">
            <span><i style="cursor: pointer;" onclick="instagram()" class="fab fa-instagram fs-1 m-2 text-primary"></i></span>
            <span><i style="cursor: pointer;" onclick="github()" class="fab fa-github fs-1 m-2 text-primary"></i></span>
            <span><li style="cursor: pointer;" onclick="linkedin()" class="fab fa-linkedin fs-1 m-2 text-primary"></li></span>
        </div>
        ',

        /* ** */

        /* SOBRE CONFIG */

        'sobre' => '
        <h2>Gratidão!</h2>
        <p>Aplicação desenvolvida por Paulo Wellington.</p>
        <p>Versão 2.0.0.</p>
        <p>Obrigado por acreditar em meu trabalho, não hesite em me enviar sugestões de melhorias.</p>
        <br>
        <div class="d-flex justify-content-center align-items-center">
            <span><i style="cursor: pointer;" onclick="instagram()" class="fab fa-instagram fs-1 m-2 text-primary"></i></span>
            <span><i style="cursor: pointer;" onclick="github()" class="fab fa-github fs-1 m-2 text-primary"></i></span>
            <span><li style="cursor: pointer;" onclick="linkedin()" class="fab fa-linkedin fs-1 m-2 text-primary"></li></span>
        </div>
        ',

        /* ** */

        /* APP MODE */

        // 0 - DEVELOPER MODE == NÃO É NECESSÁRIO ENVIAR E-MAIL DE CONFIRMAÇÃO PARA OS USUÁRIOS CADASTRADOS
        // 1 - SYSTEM MODE == É NECESSÁRIO ENVIAR E-MAIL DE CONFIRMAÇÃO PARA OS USUÁRIOS CADASTRADOS
        // OBS: AO ATIVAR O MODE '1' LEMBRE-SE DE CONFIGURAR AS INFORMAÇÕES DE E-MAIL EM EmailController E EM emailConfig.

        'mode' => '0',

        /* ** */
    ]

?>