<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CadastroController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ADMdashboardController;
use App\Http\Controllers\SuperADMController;

Route::get('vc', [CadastroController::class, 'vc']);

// CONTROLLERS DE LOGIN //

Route::get('/', [LoginController::class, 'login']);

Route::get('/login', [LoginController::class, 'login']);

Route::post('/verificarlogin', [LoginController::class, 'verificarLogin']);

Route::get('/redefenirsenha', [LoginController::class, 'redefenirSenha']);

Route::post('/verificarredefenirsenha', [LoginController::class, 'verificarRedefenirSenha']);

Route::get('/redefenirsenhacodigo', [LoginController::class, 'redefenirSenhaCodigo']);

Route::post('/validarcodigoredefenirsenha', [LoginController::class, 'redefenirSenhaCodigoValido']);

Route::get('/inserirnovasenha', [LoginController::class, 'inserirNovaSenha']);

Route::post('/novasenhaconfirmada', [LoginController::class, 'novaSenhaConfirmada']);

Route::get('/senhaalterada', [LoginController::class, 'senhaAlterada']);

Route::post('/finalizarredefenirsenha', [LoginController::class, 'finalizarRedefenirSenha']);

// ** //

// CONTROLLERS DE CADASTRO //

Route::get('/cadastro', [CadastroController::class, 'cadastro']);

Route::post('/verificarcadastro', [CadastroController::class, 'efetuarCadastro']);

Route::get('/cadastroefetuado', [CadastroController::class, 'cadastroEfetuado']);

Route::post('/validarcodigo', [CadastroController::class, 'validarCodigo']);

Route::get('/codigovalidado', [CadastroController::class, 'codigoValidado']);

Route::post('/finalizarcadastro', [CadastroController::class, 'finalizarCadastro']);

Route::post('/emailconfirmacao', [CadastroController::class, 'enviarEmailConfirmacao']);

// ** //

// CONTROLLERS DO DASHBOARD //

Route::get('/dashboard', [DashboardController::class, 'dashboard']);

Route::post('/fazerlogout', [DashboardController::class, 'fazerLogOut']);

Route::post('/inserir-reserva', [DashboardController::class, 'inserirReserva']);

Route::post('/carregar-reservas', [DashboardController::class, 'carregarReservas']);

Route::post('/excluir-reserva', [DashboardController::class, 'excluirReserva']);

Route::post('/atualizar-reserva', [DashboardController::class, 'atualizarReserva']);

Route::post('/carregarmeusdados', [DashboardController::class, 'carregarMeusDados']);

Route::post('/toggle-theme', [DashboardController::class, 'toggleTheme']);

// ** //

// CONTROLLERS DO DASHBOARD (ADM) //

Route::get('/ADMdashboard', [ADMdashboardController::class, 'ADMdashboard']);

Route::post('/ADMcarregar-reservas', [ADMdashboardController::class, 'ADMCarregarReservas']);

Route::get('/ADMagentes', [ADMdashboardController::class, 'ADMagentes']);

Route::post('/ADMcarregar-agentes', [ADMdashboardController::class, 'ADMCarregarAgentes']);

Route::post('/ADMgerar-relatorio', [ADMdashboardController::class, 'ADMGerarRelatorio']);

Route::post('/ADMobter-relatorio', [ADMdashboardController::class, 'ADMObterRelatorio']);

Route::post('/ADMver-detalhes', [ADMdashboardController::class, 'ADMVerDetalhes']);

Route::post('/ADMimprimir-relatorio-individual', [ADMdashboardController::class, 'ADMImprimirRelatorioIndividual']);

Route::post('/ADMrelatorio-individual', [ADMdashboardController::class, 'ADMRelatorioIndividual']);

Route::get('/imprimir-relatorio-individual', [ADMdashboardController::class, 'ADMRelatorioIndividualView']);

Route::post('/ADMimprimir-relatorio-geral', [ADMdashboardController::class, 'ADMImprimirRelatorioGeral']);

Route::get('/imprimir-relatorio-geral', [ADMdashboardController::class, 'ADMRelatorioGeralView']);

Route::post('/ADMobter-detalhes-dashboard', [ADMdashboardController::class, 'ADMObterDetalhesDashboard']);

Route::post('/ADMatualizar-previsao-dashboard', [ADMdashboardController::class, 'ADMAtualizarPrevisaoDashboard']);

Route::post('/ADMpagar-reserva', [ADMdashboardController::class, 'ADMPagarReserva']);

Route::post('/ADMdesfazer-pagar-reserva', [ADMdashboardController::class, 'ADMDesfazerPagarReserva']);

Route::post('/ADMprocurar-agente', [ADMdashboardController::class, 'ADMProcurarAgente']);

Route::post('/ADMprocurar-agente-info', [ADMdashboardController::class, 'ADMProcurarAgenteInfo']);

// ** //

// CONTROLLERS DO SUPER ADM //

Route::get('/administrador', [SuperADMController::class, 'administrador']);

Route::post('/SuperADM-verificar-login', [SuperADMController::class, 'SuperADMVerificarLogin']);

Route::get('/SuperADM-dashboard', [SuperADMController::class, 'SuperADMDashboard']);

Route::post('/SuperADM-carregar', [SuperADMController::class, 'SuperADMCarregar']);

Route::post('/SuperADM-efetuar-cadastro', [SuperADMController::class, 'SuperADMEfetuarCadastro']);

// ** //