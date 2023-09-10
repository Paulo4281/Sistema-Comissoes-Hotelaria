<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Agente;
use Illuminate\Support\Facades\Session;

class SessionController extends Controller
{

    // FUNÇÃO RESPONSÁVEL POR VERIFICAR SE O AGENTE ESTÁ LOGADO //

    public static function logadoAgente() {
        if (Session::has('logged-in') && Session::has('user-id') && Session::has('username') && Session::has('permission') && Session::get('permission') == 0) {
            return true;
        }
        return false;
    }

    // ** //

    // FUNÇÃO RESPONSÁVEL POR VERIFICAR SE O ADM ESTÁ LOGADO //

    public static function logadoADM() {
        if (Session::has('logged-in') && Session::has('user-id') && Session::has('username') && Session::has('permission') && Session::get('permission') == 1) {
            return true;
        }
        return false;
    }

    // ** //

    // FUNÇÃO RESPONSÁVEL POR VERIFICAR SE O SUPERADM ESTÁ LOGADO //

    public static function logadoSuperADM() {
        if (Session::has('user-id') && Session::has('username') && Session::has('SuperADM') && Session::get('SuperADM') == true) {
            return true;
        }
        return false;
    }

    // ** //

    // FUNÇÃO RESPONSÁVEL POR EFETIVAMENTE LOGAR O USUÁRIO NO SISTEMA //

    public static function loginUsuario($id, $nome, $sobrenome, $permission) {
        
        Session::put('user-id', $id);
        Session::put('username', $nome . " " . $sobrenome);
        Session::put('permission', $permission);
        Session::put('logged-in', true);

        return true;
    }

    // ** //

    // FUNÇÃO RESPONSÁVEL POR RETIRAR TODOS OS VALORES DA SESSION ATUAL //

    public static function flushSession() {
        Session::flush();
        return true;
    }

    // ** //
}
