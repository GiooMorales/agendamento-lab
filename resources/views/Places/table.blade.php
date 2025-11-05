@extends('layout')

@section('content')
    <div class="card shadow">
        <div class="card-header bg-secondary"> <h1 class="text-white fw-bold">Meus espaços</h1> </div>
        <div class="card-body">
            <table class="table table-hover text-center">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>Capacidade</th>
                        <th>Descrição</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">

                    @forelse ($places as $place)
                    <tr>
                        <td>{{$place->id}}</td>
                        <td>{{$place->name}}</td>
                        <td>{{$place->capacity}}</td>
                        <td>{{$place->description}}</td>
                        <td class="d-flax gap-1">
                            <a href="/places/{{$place->id}}/edit" class="btn btn-secondary">Editar</a>

                            <!-- Button trigger modal -->
                            {{-- data: Atributo de dados personalizados --}}
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmationModal" data-place-id="{{$place->id}}">
                                Excluir
                            </button>
                        </td>
                    </tr>
                    @empty
                        <td colspan="5">
                            <h3 class="fw-light">Nenhum ambiente cadastrado</h3>
                            <p>Para cadastrar um ambiente <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover" href="/places/new">clique aqui</a></p>
                        </td>
                    @endforelse
                    
                </tbody>
            </table>
        </div>
    </div>  


    <!-- Modal -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Aviso!</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            Deseja realmente excluir esse espaço?
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <form id="delete_place_form" method="POST">
                @method('delete')
                @csrf()
                <button type="submit" class="btn btn-danger">Excluir</button>
            </form>
            </div>
        </div>
        </div>
    </div>
@endsection

@section('scripts')
<script src="{{asset('js/confirmationModal.js')}}"></script>
@endsection