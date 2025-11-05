@extends('layout')

@section('content')


<div class="card shadow">
    <div class="card-header bg-secondary"> <h1 class="text-white fw-bold">Reservar</h1> </div>
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <input type="date" id="date" class="form-control">
            <div class="d-flex">
                <button>V</button>
                <p>Quarta-feira 6 de Agosto de 2025</p>
                <button>A</button>
            </div>
        </div>
        <table class="table table-hover text-center table-striped">
            <thead>
                <tr>
                    <th>Aulas</th>
                    @forelse ($places as $place)
                        <th>{{$place->name}}</th>
                    @empty
                        
                    @endforelse
                </tr>
            </thead>
            <tbody class="table-group-divider">


                @foreach ($schedules as $class_number=> $schedule)
                    <tr>
                        <td>{{$class_number}}</td>
                        @foreach ($schedule as $cell)
                            @if (@isset($cell->user))
                                <td>{{$cell->user->name}}</td>
                            @else
                                <td><button class="btn-schedule btn btn-primary" data-id-lab="{{$cell['place_id']}}" data-class-number="{{$class_number}}" data-shift="MANHA" >Agendar</button></td>
                            @endif
                        @endforeach
                        
                    </tr>
                    
                @endforeach

            </tbody>
        </table>
    </div> 
</div>  

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const buttons = document.querySelectorAll('.btn-schedule');
        buttons.forEach(button => {

            //Adiciona o evento de click em cada botão
            button.addEventListener('click', function(){

                const scheduling = {
                    date: document.getElementById("date").value,
                    class_number: this.dataset.classNumber,
                    shift: this.dataset.shift,
                    place_id: this.dataset.idLab,
                    user_id: {{auth()->user()->id}},
                }

                console.log(scheduling);

                //requisição
                fetch('/scheduling/new',{
                    method: 'POST',
                    headers:{
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(scheduling)
                }) 
                .then(response => response.json())
                .then(data => {
                    if(data.success){
                        alert("Agendado com sucesso!")
                    }
                }) //Fim do sucesso
                .catch(error => {
                    console.error('Erro', error);
                    alert('Erro de comunicação com o servidor')
                }) //Falha

            }) //Fim do addEventListener
        }); //Fim do foreach
    }) //Fim do DOMContentLoaded

    //busca a célula na tabela
    window.Echo.channel('schedules')
        .listen('.scheduling.created', (e) =>{
            const td = document.querySelector(`button[data-id-lab="${e.schedule.place_id}"][data-class-number="${e.schedule.class_number}"]`)?.parentElement;

            if (td) {
                td.innerHTML = "AGENDADO";
            }//fim do if
        })//fim do listen


</script>

@endsection