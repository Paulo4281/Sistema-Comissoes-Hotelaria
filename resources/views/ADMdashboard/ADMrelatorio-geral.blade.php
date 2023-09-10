@extends('ADMrelatorio-geral-layout')

@section('titulo', 'Relatório Geral')

@section('scripts')

@endsection

@section('header')

@endsection

@section('conteudo')

    <div id="area-relatorio-geral">
        <table class="table" id="table-relatorio-geral">
                <thead id="thead-relatorio-geral">
                    <th>Agente</th>
                    <th>Pix</th>
                    <th>Valor</th>
                </thead>
                <tbody id="tbody-relatorio-geral">

                </tbody>
                
        </table>
    </div>

    <h4 class="display-6 text-shadow fixed-bottom mb-4" id="text-valor-total"></h4>

@endsection

@section('footer')

@endsection