@extends('layout')

@section('content')
    <div class="card shadow">
        <div class="card-header bg-secondary"> <h1 class="text-white fw-bold">Novo espaço</h1> </div>
        <div class="card-body">
            <form action="" method="POST">
                @isset($place)
                    @method('put')
                @endisset
                @csrf
                <label for=""> Nome do espaço </label>
                <input type="text" name="name" id="" class="form-control" value="{{$place->name??null}}">

                <label for=""> Capacidade do espaço </label>
                <input type="text" name="capacity" id="" class="form-control" value="{{$place->capacity??null}}">

                <label for="">Descrição</label>
                
                <textarea name="description" id="" class="form-control mb-3"> {{$place->description??null}}</textarea>

                <button type="reset" class="btn btn-outline-secondary">Limpar</button>
                <button type="submit" class="btn btn-secondary">Salvar</button>
            </form>
        </div>
    </div>  

<div class="toast-container position-fixed top-0 end-0 p-3">
  <div data-bs-delay="2000" id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header">
      <strong class="me-auto">🐱‍🐉Bootstrap</strong>

      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
      {{session('success')}}
    </div>
  </div>
</div>

@endsection

@section('scripts')
@if (session('success') != null)
    
@endif
    <script src="{{asset('js/toast.js')}}"></script>
@endsection