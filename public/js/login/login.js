    var errorSpans = $('.error');

    $(document).ready(() => {


        errorSpans.hide();

        
    });
    
    function verificarLogin() {

        let email = $('#input-email').val();
        let senha = $('#input-senha').val();

        if (email === '' || senha === '') {
            errorSpans.eq(0).hide();
            errorSpans.eq(2).hide();
            errorSpans.eq(3).hide();
            errorSpans.eq(1).show();
            return false;
        }

        $.ajax({
            url: '/verificarlogin',
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                email: email,
                senha: senha,
            },
            success: function(response) {
                if (response.status == 1) {
                    window.location.href = '/dashboard';
                }
                else if (response.status == 3) {
                    window.location.href = '/ADMdashboard';
                }
                else if(response.status == 2) {
                    errorSpans.eq(0).hide();
                    errorSpans.eq(1).hide();
                    errorSpans.eq(3).hide();
                    errorSpans.eq(2).show();
                } else if (response.alerta == true) {
                    errorSpans.eq(3).show();
                    errorSpans.eq(0).hide();
                    errorSpans.eq(1).hide();
                    errorSpans.eq(2).hide();
                } else {
                    errorSpans.eq(1).hide();
                    errorSpans.eq(2).hide();
                    errorSpans.eq(3).hide();
                    errorSpans.eq(0).show();
                }
            }
        });

    }