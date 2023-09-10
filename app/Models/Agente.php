<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Agente extends Model
{

    // ESTE É A NOSSA TABELA PRINCIPAL DO NOSSO BANCO DE DADOS //

    protected $table = 'ag_agentes';

    protected $fillable = [
        'nome',
        'sobrenome',
        'dataNascimento',
        'genero',
        'cpf',
        'whatsapp',
        'email',
        'emailConfirmado',
        'senha',
        'senhaConfirmada',
        'pix',
        'agencia',
        'estado',
        'cidade',
        'bairro',
        'rua',
        'verificado',
        'permission',
        'DATA_CADASTRO'
    ];

    public $timestamps = false;

    // ** //
}
