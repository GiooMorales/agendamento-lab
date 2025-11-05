@extends('layout')

@section('content')
<div class="card">
    <div class="card-header bg-info">
        <h1 class="text-white fw-bolder">Novo Espaço</h1>

    </div>
    <div class="card-body">
        <form action="">
            <label for="">Nome do espaço</label>
            <input class="form-control" type="text" name="place">

            <label for="">Descrição</label>
            <textarea class="form-control mb-3" name="descripition"></textarea>

            <button class="btn btn-info" type="reset">Limpar</button>
            <button class="btn btn-info" type="submit">Salvar</button>
            
            
    </div>
</div>
@endsection