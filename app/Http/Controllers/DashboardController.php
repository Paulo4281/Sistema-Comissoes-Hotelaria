<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Agente;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\SessionController;

class DashboardController extends Controller
{

    function dashboard() {
        if (SessionController::logadoAgente()) {
            return view('dashboard/dashboard');
        }

        return redirect('login');
    }
    
    // FUNÇÃO RESPONSÁVEL POR FAZER O LOGOUT NO SISTEMA //

    function fazerLogOut() {
        if (SessionController::flushSession()) {
            return response()->json(['status' => '1']);
        }

        return response()->json(['status' => '0']);
    }

    // ** //

    // FUNÇÃO RESPONSÁVEL POR RESGATAR OS DADOS DO USUÁRIO NO BANCO DE DADOS //

    public function meusDados() {
        if (SessionController::logadoAgente()) {
            return view('dashboard/meusdados');
        } else if (SessionController::logadoADM()) {
            return view('ADMdashboard/ADMmeusdados');
        }

        return redirect('login');
    }

    public function carregarMeusDados() {

        if (SessionController::logadoAgente() || SessionController::logadoADM()) {
            $username = explode(" ", Session::get('username'));
            $dados = DB::table('ag_agentes')
            ->where('id', Session::get('user-id'))
            ->where('nome', $username[0])
            ->get();
            
            if ($dados->isEmpty()) {

                // $username = explode(" ", Session::get('username'));
                $dados = DB::table('ag_agentes_ADM')
                ->where('id', Session::get('user-id'))
                ->where('nome', $username[0])
                ->get();

                if ($dados->isEmpty()) {
                    return response()->json(['status' => '0']);
                }
            }
    
            if ($dados->count() > 0) {
                return response()->json(['status' => '1', 'dados' => $dados]);
            }

        }

        return response()->json(['status' => '0']);

    }

    // ** //

    // FUNÇÃO RESPONSÁVEL POR INSERIR UMA NOVA RESERVA NO BANCO DE DADOS //

    public function inserirReserva(Request $request) {

        if (SessionController::logadoAgente()) {

            $operadora = $request->input('operadora');
            $titular = $request->input('titular');
            $sobrenome = $request->input('sobrenome');
            $checkIn = $request->input('checkIn');
            $checkOut = $request->input('checkOut');
            $roomnights = $request->input('roomnights');
            $aptos = $request->input('aptos');
            $valor = $request->input('valor');
            $previsao = $request->input('previsao');
    
            $insert = DB::table('ag_reservas_cadastro')
            ->where('id_agente', Session::get('user-id'))
            ->insertGetId([
                'id_agente' => Session::get('user-id'),
                'agente' => Session::get('username'),
                'operadora' => $operadora,
                'titular' => $titular,
                'sobrenome' => $sobrenome,
                'check_in' => $checkIn,
                'check_out' => $checkOut,
                'roomnights' => $roomnights,
                'aptos' => $aptos,
                'valor' => $valor,
                'previsao' => $previsao,
            ]);
    
            if ($insert != null) {
                return response()->json(['status' => '1']);
            }

        }

        return response()->json(['status' => '0']);

    }

    // ** //

    // FUNÇÃO RESPONSÁVEL POR CARREGAR TODAS AS RESERVAS PERTENCENTES AO USUÁRIO //

    public function carregarReservas() {

        if (SessionController::logadoAgente()) {

            $result = DB::table('ag_reservas_cadastro')
            ->where('id_agente', Session::get('user-id'))
            ->get();
    
            if ($result->count() > 0) {
    
                $dadosReservas = array();
    
                foreach ($result as $reserva) {
                    $dadosReservas[] = array(
                        'idReserva' => $reserva->id_reserva,
                        'operadora' => $reserva->operadora,
                        'titular' => $reserva->titular,
                        'sobrenome' => $reserva->sobrenome,
                        'check_in' => $reserva->check_in,
                        'check_out' => $reserva->check_out,
                        'nights' => $reserva->roomnights,
                        'aptos' => $reserva->aptos,
                        'status' => $reserva->status,
                        'valor' => $reserva->valor,
                        'previsao' => $reserva->previsao,
                    );
                }
    
                return response()->json(['status' => '1', 'reservas' => $dadosReservas]);
                
            }
        }

        $result = DB::table('ag_reservas_cadastro_excluidas')
        ->where('id_agente', Session::get('user-id'))
        ->first();

        if ($result) {
            return response()->json(['status' => '2']);
        }

        return response()->json(['status' => '0']);

    }

    // ** //

    // FUNÇÃO RESPONSÁVEL POR EXCLUIR UMA RESERVA NO BANCO DE DADOS //

    public function excluirReserva(Request $request) {

        if (SessionController::logadoAgente()) {

            $id = $request->input('id');

            $result = DB::table('ag_reservas_cadastro')
            ->where('id_reserva', $id)
            ->first();
    
            $insertData = [
                'id_reserva' => $result->id_reserva,
                'id_agente' => $result->id_agente,
                'agente' => $result->agente,
                'operadora' => $result->operadora,
                'titular' => $result->titular,
                'sobrenome' => $result->sobrenome,
                'check_in' => $result->check_in,
                'check_out' => $result->check_out,
                'roomnights' => $result->roomnights,
                'aptos' => $result->aptos,
                'status' => $result->status,
                'adm_alteracao' => $result->adm_alteracao,
                'valor' => $result->valor,
                'previsao' => $result->previsao,
                'data_reserva_cadastro' => $result->data_reserva_cadastro,
                'data_exclusao' => now()
            ];

            $resultInsert = DB::table('ag_reservas_cadastro_excluidas')->insert($insertData);

            if ($resultInsert == true) {

                DB::table('ag_reservas_cadastro')
                ->where('id_reserva', $id)
                ->delete();

                return response()->json(['status' => '1']);
            }

        }

        return response()->json(['status' => '0']);

    }

    // ** // 

    // FUNÇÃO RESPONSÁVEL POR ATUALIZAR UMA RESERVA NO BANCO DE DADOS //

    public function atualizarReserva(Request $request) {

        if (SessionController::logadoAgente()) {

            $atualizacoes = json_decode($request->input('atualizacoes'), true);
    
            foreach ($atualizacoes as $grupo => $reserva) {
    
                $idReserva = $reserva['idReserva'][0];

                
                unset($reserva['idReserva']);
                
                foreach ($reserva as $campo => $valor) {
                    if (is_array($valor) && count($valor) === 1) {
                        $reserva[$campo] = $valor[0];
                    }
                }
    
                if (count($reserva) > 0) {
                    DB::table('ag_reservas_cadastro')
                    ->where('id_reserva', $idReserva)
                    ->update($reserva);
                    $success = true;
                }
    
                
            }
            if ($success) {
                return response()->json(['status' => '1']);
            }

        }

        return response()->json(['status' => '0']);

    }

    // ** //

    // FUNÇÃO RESPONSÁVEL POR ALTERNAR ENTRE TEMA ESCURO OU CLARO //

    public function toggleTheme() {
        
        if (Session::has('tema-escuro')) {
            Session::forget('tema-escuro');
            Session::put('tema-claro', true);
            return response()->json(['status' => '1']);
        } else {
            Session::forget('tema-claro');
            Session::put('tema-escuro', true);
            return response()->json(['status' => '1']);
        }

        return response()->json(['status' => '0']);

    }

    // ** //
}
