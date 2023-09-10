$(document).ready(() => {
    $.ajax({
        url: 'ADMcarregar-agentes',
        type: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
        },
        success: function(response) {
            if (response.status == 1) {
                let form = $('#form-agentes');
                let qtdeAgentes = $('#input-qtde-agentes');
                let agentes = response.agentes;     

                let table = $('<table>').addClass('table table-striped');
                let thead = $('<thead>');
                let tbody = $('<tbody>');

                let qtAg = 0;
    
                $('<tr>')
                    .append($('<th>').text('Nome'))
                    .append($('<th>').text('Nascimento'))
                    .append($('<th>').text('Genero'))
                    .append($('<th>').text('CPF'))
                    .append($('<th>').text('Email'))
                    .append($('<th>').text('Whatsapp'))
                    .append($('<th>').text('PIX'))
                    .append($('<th>').text('Agencia'))
                    .append($('<th>').text('Estado'))
                    .append($('<th>').text('Cidade'))
                    .append($('<th>').text('Bairro'))
                    .append($('<th>').text('Rua'))
                    .append($('<th>').text('Data do cadastro'))
                    .appendTo(thead);

                agentes.forEach(agente => {
                    if (agente.permission == 0) {
                    $('<tr>')
                    .append($('<td>').append($('<span>').text(`${agente.nome}` + " " + `${agente.sobrenome}`)))
                    .append($('<td>').append($('<span>').text(agente.dataNascimento)))
                    .append($('<td>').append($('<span>').text(agente.genero)))
                    .append($('<td>').append($('<span>').text(agente.cpf)))
                    .append($('<td>').append($('<span>').text(agente.email)))
                    .append($('<td>').append($('<span>').text(agente.whatsapp)))
                    .append($('<td>').append($('<span>').text(agente.pix)))
                    .append($('<td>').append($('<span>').text(agente.agencia)))
                    .append($('<td>').append($('<span>').text(agente.estado))) 
                    .append($('<td>').append($('<span>').text(agente.cidade)))
                    .append($('<td>').append($('<span>').text(agente.bairro)))
                    .append($('<td>').append($('<span>').text(agente.rua)))
                    .append($('<td>').append($('<span>').text(agente.DATA_CADASTRO)))
                    .appendTo(tbody);
                    qtAg++;
                }
            })

            tbody.appendTo(table);
            thead.appendTo(table);
            table.appendTo(form);
            qtdeAgentes.val(qtAg);

            } else if (response.status == 0) {
                window.location.href = 'login';
            }

            return false;

            
        }
    })
})