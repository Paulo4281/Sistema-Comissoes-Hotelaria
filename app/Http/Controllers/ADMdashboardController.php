<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Agente;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\SessionController;

class ADMdashboardController extends Controller
{

    public function ADMdashboard() {
        if (SessionController::logadoADM()) {
            return view('ADMdashboard/ADMdashboard');
        }

        return redirect('login');
    }

    // FUNÇÃO RESPONSÁVEL POR CARREGAR TODAS AS RESERVAS QUE SERÃO EXIBIDAS NO PAÍNEL DO ADM //

    public function ADMCarregarReservas() {

        $result = DB::table('ag_reservas_cadastro')
        ->orderBy('agente')
        ->get();

        $dadosReserva = array();

        if ($result->count() >= 0) {
            
            foreach ($result as $reserva) {
                $dadosReserva[] = array(
                    'idReserva' => $reserva->id_reserva,
                    'idAgente' => $reserva->id_agente,
                    'agente' => $reserva->agente,
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
            
            return response()->json(['status' => '1', 'reservas' => $dadosReserva]);

        }

        return response()->json(['status' => '0']);


    }

    // ** //

    public function ADMagentes() {
        if (SessionController::logadoADM()) {
            return view('ADMdashboard/ADMagentes');
        }

        return redirect('login');
}

    // FUNÇÃO RESPONSÁVEL POR CARREGAR TODOS OS AGENTES DO BANCO DE DADOS PARA SER EXIBIDO AO ADM //

    public function ADMCarregarAgentes() {
        if (SessionController::logadoADM()) {
            $agentes = DB::table('ag_agentes')
            ->get();

            if ($agentes->count() > 0) {
                return response()->json(['status' => '1', 'agentes' => $agentes]);
            }

            return response()->json(['status' => '0']);
        }

        return redirect('login');
    }

    // ** //

    public function ADMGerarRelatorio() {
        if (SessionController::logadoADM()) {
            return response()->json(['status' => '1']);
        }

        return response()->json(['status' => '0']);
    }

    // FUNÇÃO RESPONSÁVEL POR GERAR O RELATÓRIO AO ADM //

    public function ADMObterRelatorio(Request $request) {
        if (SessionController::logadoADM()) {

            $periodoEntre = $request->input('periodoEntre');
            $periodoAte = $request->input('periodoAte');

            $dadosReservas = DB::table('ag_reservas_cadastro')
            ->whereBetween('previsao', [$periodoEntre, $periodoAte])
            ->where('status', 'nao_pago')
            ->get();

            $dadosAgentes = DB::table('ag_agentes')
            ->get();

            if ($dadosReservas->count() > 0) {
                return response()->json(['status' => '1', 'dadosReserva' => $dadosReservas, 'dadosAgentes' => $dadosAgentes]);
            }
            else if ($dadosReservas->count() == 0) {
                return response()->json(['status' => '2']);
            }

        }

        return response()->json(['status' => '0']);
    }

    // ** //

    // FUNÇÃO RESPONSÁVEL PARA VER OS DETALHES DE CADA AGENTE //

    public function ADMVerDetalhes(Request $request) {
        if (SessionController::logadoADM()) {

            $agenteId = $request->input('agenteId');
            $periodoEntre = $request->input('periodoEntre');
            $periodoAte = $request->input('periodoAte');

            if ($agenteId) {

                $dadosAgente = DB::table('ag_agentes')
                ->where('id', $agenteId)
                ->get();

                $dadosReserva = DB::table('ag_reservas_cadastro')
                ->where('id_agente', $agenteId)
                ->where('status', 'nao_pago')
                ->whereBetween('previsao', [$periodoEntre, $periodoAte])
                ->get();

                $dadosReservaPaga = DB::table('ag_reservas_cadastro')
                ->where('id_agente', $agenteId)
                ->where('status', 'pago')
                ->get();

                if ($dadosAgente->count() == 1 && $dadosReserva->count() > 0 && $dadosReservaPaga->count() >= 0) {

                    return response()->json(['status' => '1', 'dadosAgente' => $dadosAgente, 'dadosReserva' => $dadosReserva, 'dadosReservaPaga' => $dadosReservaPaga]);

                }

                return response()->json(['status' => '0']);
            }

            return response()->json(['status' => '0']);

        }

        return response()->json(['status' => '0']);
    }

    // ** //

    // FUNÇÃO RESPONSÁVEL POR IMPRIMIR O RELÁTORIO INDIVIDUAL DE CADA AGENTE //

    public function ADMImprimirRelatorioIndividual(Request $request) {

        if (SessionController::logadoADM()) {

            $agenteId = $request->input('agenteId');

            $dadosAgente = DB::table('ag_agentes')
            ->where('id', $agenteId)
            ->get();

            if ($dadosAgente->count() > 0) {
                return response()->json(['status' => '1', 'dadosAgente' => $dadosAgente]);
            }

            return response()->json(['status' => '0']);

        }

        return response()->json(['status' => '0']);
    }



    public function ADMRelatorioIndividual(Request $request) {
        if (SessionController::logadoADM()) {

            $agente = $request->input('agente');
            $pix = $request->input('pix');
            $valor = $request->input('valor');

            if ($agente && $pix && $valor) {
                return response()->json(['status' => '1', 'agente' => $agente, 'pix' => $pix, 'valor' => $valor]);
            }

            return response()->json(['status' => $agente, 'a' => $pix, 'b' => $valor]);

        }

        return response()->json(['status' => '0']);
    }

    public function ADMRelatorioIndividualView() {
        if (SessionController::logadoADM()) {
            return view('ADMdashboard/ADMrelatorio-individual');
        }

        return response()->json(['status' => '0']);
    }

    // ** //

    // FUNÇÃO PARA MOSTRAR OS DETALHES DE CADA AGENTE PELO DASHBOARD //

    public function ADMObterDetalhesDashboard(Request $request) {
        if (SessionController::logadoADM()) {

            $agenteId = $request->input('agenteId');
            if ($agenteId) {

                $dadosAgente = DB::table('ag_agentes')
                ->where('id', $agenteId)
                ->get();


                $dadosReserva = DB::table('ag_reservas_cadastro')
                ->where('id_agente', $agenteId)
                ->where('status', 'nao_pago')
                ->get();

                $dadosReservaPaga = DB::table('ag_reservas_cadastro')
                ->where('id_agente', $agenteId)
                ->where('status', 'pago')
                ->get();

                if ($dadosAgente || $dadosReserva || $dadosReservaPaga) {

                    return response()->json(['status' => '1', 'dadosAgente' => $dadosAgente, 'dadosReserva' => $dadosReserva, 'dadosReservaPaga' => $dadosReservaPaga]);

                }

                return response()->json(['status' => '0']);
            }

            return response()->json(['status' => '0']);

        }

        return response()->json(['status' => '0']);
    }

    // ** //

    // FUNÇÃO RESPONSÁVEL POR ATUALIZAR QUAL A PREVISÃO DE PAGAMENTO NOS DETALHES DO AGENTE //

    public function ADMAtualizarPrevisaoDashboard(Request $request) {
        if (SessionController::logadoADM()) {

            $agenteId = $request->input('agenteId');
            $periodoEntre = $request->input('periodoEntre');
            $periodoAte = $request->input('periodoAte');

            
            if ($periodoEntre != '' && $periodoAte != '' && $agenteId != '') {

                $dadosReserva = DB::table('ag_reservas_cadastro')
                ->where('id_agente', $agenteId)
                ->whereBetween('previsao', [$periodoEntre, $periodoAte])
                ->where('status', 'nao_pago')
                ->get();

                $dadosReservaForaPrevisao = DB::table('ag_reservas_cadastro')
                ->where('id_agente', $agenteId)
                ->whereNotBetween('previsao', [$periodoEntre, $periodoAte])
                ->where('status', 'nao_pago')
                ->get();

                return response()->json(['status' => '1', 'dadosReserva' => $dadosReserva, 'dadosReservaForaPrevisao' => $dadosReservaForaPrevisao]);

            }

            return response()->json(['status' => '0']);

        }

        return response()->json(['status' => '0']);
    }

    // ** //

    // FUNÇÃO RESPONSÁVEL POR IMPRIMIR O RELATÓRIO DE TODOS OS AGENTES FORNECIDOS PELO RELATÓRIO DE UMA SÓ VEZ //

    public function ADMImprimirRelatorioGeral() {
        if (SessionController::logadoADM()) {
            return response()->json(['status' => '1']);
        }

        return response()->json(['status' => '0']);
    }

    public function ADMRelatorioGeralView() {
        if (SessionController::logadoADM()) {
            return view('ADMdashboard/ADMrelatorio-geral');
        }

        return response()->json(['status' => '0']);
    }

    // ** //

    // FUNÇÃO RESPONSÁVEL POR COLOCAR UMA RESERVA COM O STATUS DE 'PAGO' //

    public function ADMPagarReserva(Request $request) {
        if (SessionController::logadoADM()) {

            $reservaId = $request->input('reservaId');

            if ($reservaId) {

                $result = DB::table('ag_reservas_cadastro')
                ->where('id_reserva', $reservaId)
                ->update(['status' => 'pago', 'data_pagamento' => now()]);

                if ($result == 1) {

                    $result = DB::table('ag_reservas_cadastro')
                    ->where('id_reserva', $reservaId)
                    ->update(['adm_alteracao' => Session::get('username')]);

                    return response()->json(['status' => '1']);

                }

                return response()->json(['status' => '0']);

            }

            return response()->json(['status' => '0']);

        }

        return response()->json(['status' => '0']);
    }

    // ** //

    // FUNÇÃO RESPONSÁVEL POR COLOCAR UMA RESERVA COM O STATUS DE 'NAO_PAGO' // 

    public function ADMDesfazerPagarReserva(Request $request) {
        if (SessionController::logadoAdm()) {

            $reservaId = $request->input('reservaId');

            if ($reservaId) {

                $result = DB::table('ag_reservas_cadastro')
                ->where('id_reserva', $reservaId)
                ->update(['status' => 'nao_pago']);

                if ($result == 1) {

                    $result = DB::table('ag_reservas_cadastro')
                    ->where('id_reserva', $reservaId)
                    ->update(['adm_alteracao' => Session::get('username')]);

                    return response()->json(['status' => '1']);

                }

                return response()->json(['status' => '0']);

            }

            return response()->json(['status' => '0']);

        }

        return response()->json(['status' => '0']);
    }

    // ** //

    // FUNÇÃO RESPONSÁVEL POR PROCURAR UM AGENTE ESPECÍFICO NO BANCO DE DADOS //

    public function ADMProcurarAgente() {
        if (SessionController::logadoADM()) {

            $result = DB::table('ag_agentes')
            ->where('verificado', 1)
            ->get();

            
            if ($result->count() > 0) {
                
                $dados = [];

                foreach ($result as $res) {
                    $nome = $res->nome . " " . $res->sobrenome;
                    $id = $res->id;
                    $dados[] = ['nome' => $nome, 'id' => $id];
                }

                return response()->json(['status' => '1', 'dados' => $dados]);

            }

            return response()->json(['status' => '0']);

        }

        return redirect('login');
    }

    public function ADMProcurarAgenteInfo(Request $request) {
        if (SessionController::logadoADM()) {

            $agenteId = $request->input('agenteId');

            if ($agenteId) {

                $dadosAgente = DB::table('ag_agentes')
                ->where('id', $agenteId)
                ->get();
                
                $dadosReserva = DB::table('ag_reservas_cadastro')
                ->where('id_agente', $agenteId)
                ->where('status', 'nao_pago')
                ->get();
                
                $dadosReservaPaga = DB::table('ag_reservas_cadastro')
                ->where('id_agente', $agenteId)
                ->where('status', 'pago')
                ->get();
                
                if ($dadosAgente->count() == 1 && $dadosReserva->count() >= 0 && $dadosReservaPaga->count() >= 0) {
                    
                    return response()->json(['status' => '1', 'dadosAgente' => $dadosAgente, 'dadosReserva' => $dadosReserva, 'dadosReservaPaga' => $dadosReservaPaga]);

                }

            }

            return response()->json(['status' => '0']);

        }

        return redirect('login');
    }

    // ** //

}