$(document).ready(() => {
    let errorSpans = $('.error');

    errorSpans.hide();
})

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
    
    let regex = /^(?=.*[a-zA-Z])(?=.*\d).+$/;
    let erroSenhaFraca = $("#error-senha-formato");
    
    if (!regex.test(senha)) {

      erroSenhaFraca.show();
      return false;

    } else {
      erroSenhaFraca.hide();
    }
  });

function verificarSenhas() {
    let senha = $("#input-senha").val();
    let senhaConfirmada = $("#input-senha-confirmada").val();
    let erroSenhaConfirmada = $("#error-senha-diferente");
    let erroSenhaMinimoCaracteres = $("#error-senha-minimo-caracteres");
    let erroSenhaFraca = $("#error-senha-formato");
    let regex = /^(?=.*[a-zA-Z])(?=.*\d).+$/;

    if (senha !== senhaConfirmada) {

      erroSenhaConfirmada.show();
      return false;

    } else {
      erroSenhaConfirmada.hide();
    }

    if (senha.length < 8) {

      erroSenhaMinimoCaracteres.show();
      return false;

  } else {
      erroSenhaMinimoCaracteres.hide();
  }

  if (!regex.test(senha)) {

    erroSenhaFraca.show();
    return false;

  } else {
    erroSenhaFraca.hide();
  }

    if (senha == senhaConfirmada) {
        $.ajax({
            url: 'novasenhaconfirmada',
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                senha: senha,
                senhaConfirmada: senhaConfirmada,
            },
            success: function(response) {
                if (response.status == 1) {
                    window.location.href = 'senhaalterada';
                } else {
                    return false;
                }
            } 
        })
    }

    return false;
}