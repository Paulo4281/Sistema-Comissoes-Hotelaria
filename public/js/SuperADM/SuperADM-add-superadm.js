$(document).ready(() => {

    $('.error').hide();

    $('#superadm-senha-confirmada').on("input", function(event) {
    
        let senha = $("#superadm-senha").val();
        let senhaConfirmada = $("#superadm-senha-confirmada").val();
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

function addSuperADM() {
    let modalAdd = $('#modal-add-superadm');
    modalAdd.modal('show');
}

function cadastrarSuperADM() {

    let errorDados = $('#modal-error-dados');
    let modalCadastradoEfetuado = $('#modal-superadm-cadastro-efetuado');
    let modalAdd = $('#modal-add-superadm');

    let senha = $("#superadm-senha").val();
    let senhaConfirmada = $("#superadm-senha-confirmada").val();

    if (senha != senhaConfirmada) {
        errorDados.modal('show');
        return false;
    }

    let nome = $('#superadm-nome').val();
    let sobrenome = $('#superadm-sobrenome').val();
    let email = $('#superadm-email').val();

    if (nome == '' || sobrenome == '' || email == '') {
        errorDados.modal('show');
        return false;
    }

    $.ajax({
        url: 'SuperADM-efetuar-cadastro',
        type: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            nome: nome,
            sobrenome: sobrenome,
            email: email,
            senha: senha
        },
        success: function(response) {
            if (response.status = 1){
                modalAdd.hide();
                modalCadastradoEfetuado.modal('show');
                setTimeout(() => {
                    location.reload();
                }, 1500)
            } else {
                errorDados.modal('show');
                return false;
            }
        }
    })

}