<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Agente;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\ADMdashboardController;
use Jenssegers\Agent\Facades\Agent;

class SuperADMController extends Controller
{

    protected $limiteTentativasLoginSuperADM;

    public function __construct() {
        $this->limiteTentativasLoginSuperADM = config('configuracoes.limiteTentativasLoginSuperADM');
    }

    public function administrador() {
        if (SessionController::logadoAgente() || SessionController::logadoADM()) {
            return redirect('login');
        }

        if (SessionController::logadoSuperADM()) {
            return view('SuperADM/SuperADMDashboard');
        }

        return view('SuperADM/SuperADMLogin');
    }

    public function SuperADMDashboard() {
        if (SessionController::logadoAgente() || SessionController::logadoADM()) {
            return redirect('login');
        }

        if (SessionController::logadoSuperADM()) {
            return view('SuperADM/SuperADMDashboard');
        }

        return redirect('login');

    }

    // FUNÇÃO RESPONSÁVEL POR RESGATAR TODOS OS ADMS CADASTRADOS NO BANCO DE DADOS E EXIBIR AO SUPERADM DA SESSÃO ATUAL //

    public function SuperADMCarregar() {
        if (SessionController::logadoAgente() || SessionController::logadoADM()) {
            return redirect('login');
        }

        if (SessionController::logadoSuperADM()) {

            $superadmUsers = DB::table('ag_agentes_adm')
            ->get();

            if ($superadmUsers->count() > 0) {
                return response()->json(['status' => '1', 'dados' => $superadmUsers]);
            }

            return response()->json(['status' => '0']);

        }

        return redirect('login');
    }

    // ** //

    // FUNÇÃO RESPONSÁVEL POR EFETUAR UM NOVO CADASTRO DE UM SUPERADM NO BANCO DE DADOS //

    public function SuperADMEfetuarCadastro(Request $request) {
        if (SessionController::logadoAgente() || SessionController::logadoADM()) {
            return redirect('login');
        }

        if (SessionController::logadoSuperADM()) {

            $nome = $request->input('nome');
            $sobrenome = $request->input('sobrenome');
            $email = $request->input('email');
            $senha = $request->input('senha');

            if ($nome != '' && $sobrenome != '' && $email != '' && $senha != '') {

                $hash = bcrypt($senha);
                $verificado = 1;
                $permission = 1;

                $response = DB::table('ag_agentes_adm')
                ->insert([
                    'nome' => $nome,
                    'sobrenome' => $sobrenome,
                    'email' => $email,
                    'senha' => $hash,
                    'verificado' => $verificado,
                    'permission' => $permission,
                    'DATA_CADASTRO' => now()
                ]);

                if ($response) {
                    return response()->json(['status' => '1']);
                }

                return response()->json(['status' => '0']);

            }

            return response()->json(['status' => '0']);

        }

        return redirect('login');
    }

    // ** //

    // FUNÇÃO RESPONSÁVEL POR VERIFICAR SE O EMAIL DIGITADO PELO SUPERADM NO MOMENTO DO LOGIN PASSA PELOS TESTES DE VALIDAÇÃO //

    public function SuperADMVerificarLogin(Request $request) {
        if (SessionController::logadoAgente() || SessionController::logadoADm()) {
            return redirect('login');
        }

        $email = $request->input('email');
        $senha = $request->input('senha');

        try {

            $usuario = DB::table('ag_agentes_adm')
            ->where('email', $email)
            ->first();

            if ($usuario) {
                $tentativas = DB::table('ag_login_tentativas_superadm')
                ->where('email', $email)
                ->count();

                if ($tentativas >= $this->limiteTentativasLoginSuperADM) {
                    return response()->json(['status' => '2']);
                }
            } else {
                DB::table('ag_login_tentativas_superadm')
                ->insert([
                    'email' => $email,
                    'endereco_ip' => $request->ip(),
                    'plataforma' => Agent::platform(),
                    'browser' => Agent::browser(),
                ]);
            }

            if ($usuario) {
                if (!password_verify($senha, $usuario->senha)) {
                    DB::table('ag_login_tentativas_superadm')
                    ->insert([
                        'email' => $email,
                        'endereco_ip' => request()->ip(),
                        'plataforma' => Agent::platform(),
                        'browser' => Agent::browser(),
                        'DATA_HORA' => now()
                    ]);
                    return response()->json(['status' => '0']);
                } else {
                    DB::table('ag_login_sucedidos_superadm')
                    ->insert([
                        'id_usuario' => $usuario->id,
                        'email' => $usuario->email,
                        'endereco_ip' => request()->ip(),
                        'plataforma' => Agent::platform(),
                        'browser' => Agent::browser(),
                        'DATA_HORA' => now(),
                    ]);
                    Session::put('user-id', $usuario->id);
                    Session::put('username', $usuario->nome . " " . $usuario->sobrenome);
                    Session::put('SuperADM', true);
                    return response()->json(['status' => '1']);
                }
            }

            return response()->json(['status' => '0']);

        } catch (Expection $e) {
            return reponse()->json(['status' => '0', 'message' => $e]);
        }
    }

    // ** //
}
