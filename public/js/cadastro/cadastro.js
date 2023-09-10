  $(document).ready(() => {

        // ESCONDE SPAN DOS ERROS //

        var errorSpans = $('.error');
        let errorCampos = $('#error-verificar-campos');

        errorCampos.hide();
        errorSpans.hide();

        // ** //

        // MASCARAS //

        $('#input-cpf').mask('999.999.999-99');
        $('#input-whatsapp').mask('(99)99999-9999');

        // ** //

        // VERIFICACAO DA SENHA //

        $('#input-senha-confirmada').on("input", function(event) {
    
            let senha = $("#input-senha").val();
            let senhaConfirmada = $("#input-senha-confirmada").val();
            let erroSenhaConfirmada = $("#error-senha-diferente");
            
            if (senha !== senhaConfirmada) {
    
              erroSenhaConfirmada.show();
              return false;
    
            } else {
              erroSenhaConfirmada.hide();
            }
          
            let erroSenhaMinimoCaracteres = $("#error-senha-minimo-caracteres");
              if (senha.length < 8) {
    
                  erroSenhaMinimoCaracteres.show();
                  return false;
    
              } else {
                  erroSenhaMinimoCaracteres.hide();
              }
            
            var regex = /^(?=.*[a-zA-Z])(?=.*\d).+$/;
            var erroSenhaFraca = $("#error-senha-formato");
            
            if (!regex.test(senha)) {
    
              erroSenhaFraca.show();
              return false;
    
            } else {
              erroSenhaFraca.hide();
            }
          });
    });

    // ** //

    function verificarForm(event) {

        let form = $('#formulario-cadastro');

        let errorModal = $('#errorModal');
        let errorRegulamentoModal = $('#error-regulamento-modal');
        let errorEmailModal = $('#error-email-modal');
        let errorSenhaModal = $('#error-senha-modal');

        let errorEmailInvalido = $('#error-email-invalido-modal');
        let errorCpfInvalido = $('#error-cpf-invalido-modal'); 
        let errorWhatsappInvalido = $('#error-whatsapp-invalido-modal')
        let errorIdadeInvalido = $('#error-idade-invalido-modal');

        let cadastroBtn = $('#cadastro-button');
        let loadGif = $('#cadastro-btn-load-gif');
        let btnText = $('#cadastro-btn-text');

        // OBTENCAO DE TODOS OS VALORES A SEREM ENVIADOS AO SERVIDOR //

        let nome = $('#input-nome').val();
        let sobrenome = $('#input-sobrenome').val();
        let dataNascimento = $('#input-data-nascimento').val();
        let genero = $('#input-genero-r1').prop('checked') ? $('#input-genero-r1').val() : $('#input-genero-r2').val();
        let cpf = $('#input-cpf').val();
        let whatsapp = $('#input-whatsapp').val();
        let email = $('#input-email').val();
        let emailConfirmado = $('#input-email-confirmado').val();
        let senha = $('#input-senha').val();
        let senhaConfirmada = $('#input-senha-confirmada').val();
        let pix = $('#input-pix').val();
        let agencia = $('#input-agencia').val();
        let estado = $('#input-estado').val();
        let cidade = $('#input-cidade').val();
        let bairro = $('#input-bairro').val();
        let rua = $('#input-rua').val();
        let regulamento = $('#input-checkbox-regulamento').prop('checked');

        if (nome == '' || sobrenome == '' || dataNascimento == '' || genero == '' || cpf == '' || whatsapp == '' || email == '' || emailConfirmado == '' || senha == '' || senhaConfirmada == '' || pix == '' || agencia == '' || estado == '' || cidade == '' || bairro == '' || rua == '') {
            errorModal.modal('show');
            return false;
        }

        if (senha != senhaConfirmada) {
          errorSenhaModal.modal('show');
          return false;
        }
        if (email != emailConfirmado) {
          errorEmailModal.modal('show');
          return false;
        }
        if (regulamento == false) {
          errorRegulamentoModal.modal('show');
          return false;
        }

        // ** //

        cadastroBtn.prop('disabled', true);
        loadGif.addClass('spinner-border spinner-border-sm');
        btnText.text('Aguarde...');

        // REQUISICAO AJAX AO SERVIDOR //

        $.ajax({
            url: 'verificarcadastro',
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                nome: nome,
                sobrenome: sobrenome,
                dataNascimento: dataNascimento,
                genero: genero,
                cpf: cpf,
                whatsapp: whatsapp,
                email: email,
                emailConfirmado: emailConfirmado,
                senha: senha,
                senhaConfirmada: senhaConfirmada,
                pix: pix,
                agencia: agencia,
                estado: estado,
                cidade: cidade,
                bairro: bairro,
                rua: rua,
                },
            success: function(response) {
              console.log(response);
                if (response.status == 1) {
                  window.location.href = "cadastroefetuado";
                }  else if (response.status == 0) {
                  errorModal.modal('show');
                  loadGif.removeClass();
                  btnText.text('Efetuar cadastro');
                  cadastroBtn.prop('disabled', false);
                  return false;
                } else if (response.status == 4) {
                  errorEmailInvalido.modal('show');
                  loadGif.removeClass();
                  btnText.text('Efetuar cadastro');
                  cadastroBtn.prop('disabled', false);
                  return false;
                } else if (response.status == 5) {
                  errorCpfInvalido.modal('show');
                  loadGif.removeClass();
                  btnText.text('Efetuar cadastro');
                  cadastroBtn.prop('disabled', false);
                  return false;
                } else if (response.status == 6) {
                  errorWhatsappInvalido.modal('show');
                  loadGif.removeClass();
                  btnText.text('Efetuar cadastro');
                  cadastroBtn.prop('disabled', false);
                  return false;
                } else if (response.status == 7) {
                  errorIdadeInvalido.modal('show');
                  loadGif.removeClass();
                  btnText.text('Efetuar cadastro');
                  cadastroBtn.prop('disabled', true);
                  return false;
                } else {
                  errorModal.modal('show');
                  loadGif.removeClass();
                  btnText.text('Efetuar cadastro');
                  cadastroBtn.prop('disabled', false);
                  return false;
                }
            }
        });

        // ** //
        
    }