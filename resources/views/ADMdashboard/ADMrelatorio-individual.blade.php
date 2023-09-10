@extends('ADMrelatorio-individual-layout')

@section('titulo', 'Relatório')

@section('scripts')
<script src="{{ asset('js/ADMdashboard/ADMrelatorio-individual.js') }}"></script>
@endsection

@section('header')

@endsection

@section('conteudo')

<table class="table" id="area-relatorio-individual">
    <thead>
        <tr>
            <th>Agente</th>
            <th>Pix</th>
            <th>Valor</th>
        </tr>
    </thead>
    <tbody>
        <tr>
        <td><h6 id="relatorio-agente"></h6></td>
        <td><h6 id="relatorio-pix"></h6></td>
        <td><h6 id="relatorio-valor"></h6></td>
        </tr>
    </tbody>
</table>


@endsection

@section('footer')

@endsection