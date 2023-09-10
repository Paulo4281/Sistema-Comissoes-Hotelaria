@extends('ADMDashboard-layout')

@section('titulo', 'Agentes')

@section('scripts')
<script src="{{ asset('js/ADMdashboard/ADMcarregar-agentes.js') }}"></script>
@endsection

@section('header')

@endsection

@section('conteudo')
    <div style="position: sticky; top: 0; z-index: 999;">
        <input type="text" class="form-control bg-info form-control-sm text-center fs-1" id="input-qtde-agentes" data-bs-toggle="tooltip" title="Quantidade de agentes" readonly>
    </div>
    <form id="form-agentes">

    </form>
@endsection

@section('footer')

@endsection