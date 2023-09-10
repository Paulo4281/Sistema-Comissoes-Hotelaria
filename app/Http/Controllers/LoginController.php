<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Agente;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\SessionController;
use Jenssegers\Agent\Facades\Agent;

class LoginController extends Controller
{

    protected $limiteTentativasLogin;

    public function __construct() {
        $this->limiteTentativasLogin = config('configuracoes.limiteTentativasLogin');
    }

    public function login() {
        if (SessionController::logadoAgente()) {
            return view('dashboard/dashboard');
        } else if (SessionController::logadoADM()) {
            return view('ADMdashboard/ADMdashboard');
        } else if (SessionController::logadoSuperADM()) {
            return view('SuperADM/SuperADMDashboard');
        }
        return view('login/login');
    }

    public function redefenirSenha() {
        if (SessionController::logadoAgente()) {
            return view('dashboard/dashboard');
        } else if (SessionController::logadoADM()) {
            return view('ADMdashboard/ADMdashboard');
        } else if (SessionController::logadoSuperADM()) {
            return view('SuperADM/SuperADMDashboard');
        }
        return view('redefenirsenha/redefenirsenha');
    }

    // FUNÇÃO RESPONSÁVEL POR VERIFICAR SE O EMAIL DIGITADO PELO USUÁRIO NO MOMENTO DE REDEFENIR A SENHA PASSA PELOS TESTES DE VALIDAÇÃO NECESSÁRIOS //

    public function verificarRedefenirSenha(Request $request) {

        $email = $request->input('email');

        try {

            $usuario = DB::table('ag_agentes')->where('email', $email)->first();

            if (!$usuario) {

                $usuario = DB::table('ag_agentes_adm')->where('email', $email)->first();

                if (!$usuario) {
                    return response()->json(['status' => '0']);
                }

                Session::put('SuperADM-redefenir-senha', true);

            }

            $nome = $usuario->nome;

            if (!Session::has('username') && !Session::has('user-email')) {
                Session::put('username', $nome);
                Session::put('user-email', $email);
            }
            
            if (!Session::has('redefenir-senha')) {
                Session::put('redefenir-senha', true);
                if (config('configuracoes.mode') == 1) {
                    EmailController::enviarEmailRedefenirSenha(Session::get('user-email'), Session::get('username'));
                } else if (config('configuracoes.mode') == 0) {
                    return response()->json(['status' => '1']);
                }
                return response()->json(['status' => '1']);
            }

        } catch (Exception $e) {
            // echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // ** //

    public function redefenirSenhaCodigo() {
            if (Session::has('redefenir-senha')) {
                return view('/redefenirsenha/redefenirsenhacodigo');
            }

            return redirect('login');
    }

    // FUNÇÃO RESPONSÁVEL POR VERIFICAR SE O CÓDIGO DIGITADO PELO USUÁRIO PARA REDEFENIR A SENHA ESTÁ CORRETO //

    public function redefenirSenhaCodigoValido(Request $request) {

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
            Session::put('nova-senha', true);
            return response()->json(['status' => '1']);
        }

        return response()->json(['status' => '0']);
    }

    // ** //

    public function inserirNovaSenha() {
        if (Session::has('nova-senha') && Session::get('nova-senha') == true) {
            return view('redefenirsenha/inserirnovasenha');
        }

        return redirect('login');
    }

    // FUNÇÃO RESPONSÁVEL POR EFETIVAMENTE TROCAR A SENHA DO USUÁRIO NO BANCO DE DADOS //

    public function novaSenhaConfirmada(Request $request) {

        $senha = $request->input('senha');
        $senhaConfirmada = $request->input('senhaConfirmada');

        if ($senha == $senhaConfirmada) {

            $hash = bcrypt($senha);

            if (Session::has('SuperADM-redefenir-senha') && Session::get('SuperADM-redefenir-senha') == true) {
                DB::table('ag_agentes_adm')
                ->where('email', Session::get('user-email'))
                ->update(['senha' => $hash]);

                Session::put('senha-alterada', true);
            }

            DB::table('ag_agentes')
            ->where('email', Session::get('user-email'))
            ->update(['senha' => $hash]);

            Session::put('senha-alterada', true);

            return response()->json(['status' => '1']);

        }

        return response()->json(['status' => '0']);

    }

    // ** //

    public function senhaAlterada() {
        if (Session::has('senha-alterada') && Session::get('senha-alterada') == true) {
            return view('redefenirsenha/senhaalterada');
        }

        return redirect('login');
    }

    public function finalizarRedefenirSenha() {
        if (SessionController::flushSession()) {
            return response()->json(['status' => '1']);
        }

        return response()->json(['status' => '0']);

    }

    // FUNÇÃO RESPONSÁVEL POR VERIFICAR SE O EMAIL DIGITADO PELO USUÁRIO NO MOMENTO DO LOGIN PASSA PELOS TESTES DE VALIDAÇÃO NECESSÁRIOS //

    public function verificarLogin(Request $request) {

        $email = $request->input('email');
        $senha = $request->input('senha');

        try {

        // VERIFICAR SE O EMAIL EXISTE NO BANCO DE DADOS //
        $usuario = DB::table('ag_agentes')->where('email', $email)->first();
        // ** //

        if (!$usuario) {
            $usuario = DB::table('ag_agentes_adm')->where('email', $email)->first();
            if (!$usuario) {
                return response()->json(['status' => '0']);
            } 
        }

        // VERIFICAR SE O NÚMERO DE TENTATIVAS FOI EXCEDIDO //
        $tentativas = DB::table('ag_login_tentativas')->where('email', $email)->count();
        if ($tentativas >= $this->limiteTentativasLogin) {
            return response()->json(['status' => '2']);
        } else if ($tentativas == ($this->limiteTentativasLogin - 3)) {
            $alerta = true;
        } else {
            $alerta = false;
        }
        // ** //

        // LÓGICA PARA LIDAR CASO EMAIL NÃO EXISTA //
        if (!$usuario) {
            DB::table('ag_login_tentativas')->insert([
                'email' => $email,
                'data_hora' => now(),
                'endereco_ip' => $request->ip(),
                'plataforma' => Agent::platform(),
                'browser' => Agent::browser(),
            ]);
            // ** //
        }

        // LÓGICA PARA LIDAR CASO O EMAIL EXISTA //
        if ($usuario) {
            // VERIFICA SE O EMAIL JÁ FOI VALIDADO //
            if ($usuario->verificado != 1) {
                return response()->json(['status' => '0', 'alerta' => $alerta]);
            }
            // ** //

            // VERIFICA SE A SENHA CONFERE //
            if (!password_verify($senha, $usuario->senha)) {
                DB::table('ag_login_tentativas')->insert([
                    'email' => $email,
                    'endereco_ip' => request()->ip(),
                    'plataforma' => Agent::platform(),
                    'browser' => Agent::browser(),
                    'DATA_HORA' => now(),
                ]);
                return response()->json(['status' => '0', 'alerta' => $alerta]);
            }
            // ** //

            if ($usuario->permission == 0) {
                if (SessionController::loginUsuario($usuario->id, $usuario->nome, $usuario->sobrenome, $usuario->permission)) {

                    DB::table('ag_login_sucedidos')->insert([
                        'id_usuario' => $usuario->id,
                        'email' => $usuario->email,
                        'endereco_ip' => request()->ip(),
                        'plataforma' => Agent::platform(),
                        'browser' => Agent::browser(),
                        'DATA_HORA' => now(),
                    ]);

                    DB::table('ag_login_tentativas')
                    ->where('email', $usuario->email)
                    ->delete();

                    return response()->json(['status' => '1']);
                }
            } else if ($usuario->permission == 1) {
                if (SessionController::loginUsuario($usuario->id, $usuario->nome, $usuario->sobrenome, $usuario->permission)) {

                    DB::table('ag_login_sucedidos')->insert([
                        'id_usuario' => $usuario->id,
                        'email' => $usuario->email,
                        'endereco_ip' => request()->ip(),
                        'plataforma' => Agent::platform(),
                        'browser' => Agent::browser(),
                        'DATA_HORA' => now(),
                    ]);

                    DB::table('ag_login_tentativas')
                    ->where('email', $usuario->email)
                    ->delete();

                    return response()->json(['status' => '3']);
                }
            }

            return response()->json(['status' => '0', 'alerta' => $alerta]);

        }

    
    } catch (Excepion $e) {
            // echo "Error: " . $e->getMessage();
            return response()->json(['status' => '0']);
    }
}

    // ** //
}