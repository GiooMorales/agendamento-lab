@extends('layout')

@section('content')
    <h1>Bem vindo - Sistema de Agendamento</h1>
    <ul>
        <li> <a href="/">Início</a> </li>
        <li> <a href="/places">Meus Espaços</a> </li>
        <li> <a href="/places/new">Novos Espaços</a> </li>
        <li> <a href="/scheduling">Agendamentos</a> </li>
        <li> {{auth()->user()->name}} <a href="/logout">  Sair</a> </li>
    </ul>

@endsection