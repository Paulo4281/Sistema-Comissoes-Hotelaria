<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cadastro;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Agente;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\SessionController;
use DateTime;

class CadastroController extends Controller
{

    public function cadastro() {
        if (SessionController::logadoAgente()) {
            return view('dashboard/dashboard');
        } else if (SessionController::logadoADM()) {
            return view('ADMdashboard/ADMdashboard');
        } else if (SessionController::logadoSuperADM()) {
            return view('SuperADM/SuperADMDashboard');
        }
        return view('cadastro/cadastro');
    }

    // FUNÇÃO RESPONSÁVEL POR CHAMAR A FUNÇÃO DE ENVIAR UM EMAIL DE CONFIRMAÇÃO PARA O USUÁRIO QUE ACABOU DE SE CADASTRAR //

    public function enviarEmailConfirmacao($userEmail, $username) {
        EmailController::enviarEmailConfirmacao($userEmail, $username);
    }

    // ** //

    public function cadastroEfetuado() {
        if (Session::has('verificar-codigo') && Session::get('verificar-codigo') == true) {
            return view('cadastro/cadastroefetuado');
        }

        return redirect('login');
    }

    // FUNÇÃO RESPONSÁVEL POR VERIFICAR SE O CÓDIGO DE CONFIRMAÇÃO DIGITADO PELO USUÁRIO ESTÁ CORRETO //

    public function validarCodigo(Request $request) {

        if (Session::get('codigo')) {
            $token = Session::get('codigo');
        } else {
            if (config('configuracoes.mode') == 0) {
                $token = '123456';
            } else {
                $token = '';
            }
        }

        $codigo = $request->input('codigo');

        if ($codigo == $token) {
            Session::put('codigo-validado', true);

            $result = DB::table('ag_agentes_nao_verificados')
            ->where('id', Session::get('user-id'))
            ->where('email', Session::get('user-email'))
            ->first();

            if ($result) {

                $result = DB::table('ag_agentes')
                ->insert([
                    'nome' => $result->nome,
                    'sobrenome' => $result->sobrenome,
                    'dataNascimento' => $result->dataNascimento,
                    'genero' => $result->genero,
                    'cpf' => $result->cpf,
                    'email' => $result->email,
                    'senha' => $result->senha,
                    'whatsapp' => $result->whatsapp,
                    'pix' => $result->pix,
                    'agencia' => $result->agencia,
                    'estado' => $result->estado,
                    'cidade' => $result->cidade,
                    'bairro' => $result->bairro,
                    'rua' => $result->rua,
                    'verificado' => 1,
                    'permission' => $result->permission,
                ]);

                if ($result) {

                    $result = DB::table('ag_agentes_nao_verificados')
                    ->where('id', Session::get('user-id'))
                    ->where('email', Session::get('user-email'))
                    ->delete();

                    if ($result) {
                        return response()->json(['status' => '1']);
                    }

                    return response()->json(['status' => '0']);

                }

                return response()->json(['status' => '0']);

            }

            return response()->json(['status' => '0']);

        }

        return response()->json(['status' => '0']);

    }

    // ** //

    public function codigoValidado() {
        if (Session::has('codigo-validado') && Session::get('codigo-validado') == true) {
            return view('cadastro/codigovalidado');
        }

        return redirect('login');
    }

    public function finalizarCadastro() {
        if (SessionController::flushSession()) {
            return response()->json(['status' => '1']);
        }

        return response()->json(['status' => '0']);

    }

    // FUNÇÃO RESPONSÁVEL POR EFETUAR A INCLUSÃO DOS DADOS DO USUÁRIO QUE ACABOU DE SE REGISTRAR NO BANCO DE DADOS //

    public function efetuarCadastro(Request $request) {
        try {

        $nome = $request->input('nome');
        $sobrenome = $request->input('sobrenome');
        $dataNascimento = $request->input('dataNascimento');
        $genero = $request->input('genero');
        $cpf = $request->input('cpf');
        $whatsapp = $request->input('whatsapp');
        $email = $request->input('email');
        $emailConfirmado = $request->input('emailConfirmado');
        $senha = $request->input('senha');
        $senhaConfirmada = $request->input('senhaConfirmada');
        $pix = $request->input('pix');
        $agencia = $request->input('agencia');
        $estado = $request->input('estado');
        $cidade = $request->input('cidade');
        $bairro = $request->input('bairro');
        $rua = $request->input('rua');

        // VERIFICA SE EXISTE UM EMAIL JÁ CADASTRADO ENTRE OS AGENTES //
        $agente = DB::table('ag_agentes')
        ->where('email', $email)
        ->first();

        if ($agente) {
            return response()->json(['status' => '4']);
        }

        $agente = DB::table('ag_agentes_nao_verificados')
        ->where('email', $email)
        ->first();

        if ($agente) {
            return response()->json(['status' => '4']);
        }
        // ** //

        // VERIFICA SE EXISTE UM EMAIL JÁ CADASTRADO ENTRE OS ADMS //
        $agente = DB::table('ag_agentes_adm')
        ->where('email', $email)
        ->first();

        if ($agente) {
            return response()->json(['status' => '4']);
        }
        // ** //

        // VALIDAÇÃO DOS DADOS //

        if (!self::validarCpf($cpf)) {
            return response()->json(['status' => '5']);
        }

        if (!self::validarCelular($whatsapp)) {
            return response()->json(['status' => '6']);
        }

        if (!self::validarIdade($dataNascimento)) {
            return response()->json(['status' => '7']);
        }

        // ** //

        $hash = bcrypt($senha);
        $verificado = 0;
        $permission = 0;

        $result = DB::table('ag_agentes_nao_verificados')
        ->insertGetId([
            'nome' => $nome,
            'sobrenome' => $sobrenome,
            'dataNascimento' => $dataNascimento,
            'genero' => $genero,
            'cpf' => $cpf,
            'email' => $email,
            'senha' => $hash,
            'whatsapp' => $whatsapp,
            'pix' => $pix,
            'agencia' => $agencia,
            'estado' => $estado,
            'cidade' => $cidade,
            'bairro' => $bairro,
            'rua' => $rua,
            'verificado' => $verificado,
            'permission' => $permission,
        ]);

        if ($result) {
            $id = $result;
            Session::put('username', $nome);
            Session::put('user-id', $id);
            Session::put('verificar-codigo', true);
            Session::put('user-email', $email);

            if (config('configuracoes.mode') == 1) {
                self::enviarEmailConfirmacao(Session::get('user-email'), Session::get('username'));
            } else if (config('configuracoes.mode') == 0){
                return response()->json(['status' => '1']);
            }


            return response()->json(['status' => '1']);
        }
    } catch (Exception $e) {
        // echo "Error: " . $e;
        return response()->json(['status' => '0']);
    }

    }

    // ** //

    // FUNÇÕES RESPONSÁVEIS POR VERIFICAR ALGUNS DADOS ENVIADOS DO LADO DO CLIENTE AO SERVIDOR //

    protected function validarCpf($cpf) {
        $cpf = preg_replace('/\D/', '', $cpf);

        if (strlen($cpf) != 11) {
            return false;
        }

        $cpfValidation = substr($cpf, 0, 9);
        $cpfTamanho = strlen($cpfValidation);
        $cpfMultiplicador = $cpfTamanho + 1;
        $soma = 0;
        for ($i = 0; $i < $cpfTamanho; $i++) {
            $soma += $cpfValidation[$i] * $cpfMultiplicador;
            $cpfMultiplicador--;
        }
        $resto = $soma % 11;
        $dv1 = ($resto > 1) ? 11 - $resto : 0;

        $cpfValidation .= $dv1;
        $cpfTamanho = strlen($cpfValidation);
        $cpfMultiplicador = $cpfTamanho + 1;
        $soma = 0;
        for ($i = 0; $i < $cpfTamanho; $i++) {
            $soma += $cpfValidation[$i] * $cpfMultiplicador;
            $cpfMultiplicador--;
        }
        $resto = $soma % 11;
        $dv2 = ($resto > 1) ? 11 - $resto : 0;

        return ($cpf[9] == $dv1 && $cpf[10] == $dv2);
    }

    protected function validarCelular($whatsapp) {
        $whatsapp = preg_replace('/\D/', '', $whatsapp);

        if (strlen($whatsapp) != 11) {
            return false;
        }

        if (substr($whatsapp, 2, 1) != '9') {
            return false;
        }

        $segundoDigito = substr($whatsapp, 3, 1);
        if ($segundoDigito == '6' || $segundoDigito == '7' || $segundoDigito == '8' || $segundoDigito == '9') {
            return true;
        }

        return false;
    }

    protected function validarIdade($dataNascimento) {
        $dataNascimento = new DateTime($dataNascimento);
        $today = new DateTime();
        $idade = $today->diff($dataNascimento)->y;

        return $idade >= 18;
    }

    // ** //

}
