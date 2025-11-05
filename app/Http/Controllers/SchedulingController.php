<?php

namespace App\Http\Controllers;

use App\Models\Scheduling;
use App\Models\Place;
use Illuminate\Http\Request;
use App\Events\SchedulingCreated;

class SchedulingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // $places = Place::all(); //SELECT * FROM places
        // return view('Scheduling/index', ['places' => $places]);

        //Data atual
        $date= now()->toDateString();

        //Colunas = labs
        $places = Place::orderBy('name')->get(['id','name']);

        //Linha = Aulas (1 até 7)
        $classNumber = range(1,7);
        
        $schedules = Scheduling::query()
        ->select(['class_number', 'place_id', 'user_id', 'shift']) //Trás os campos do BD
        ->with(['user:id,name', 'place:id,name']) //Faz buscas na outr tabela
        ->whereDate('date', $date) //Condição
        ->get() //Realiza a consulta
        ->keyBy(fn($s) => $s->class_number.'-'.$s->place_id); //Chave

        $lookup= [];
        foreach ($classNumber as $class) {
            foreach ($places as $place) {
                //Pega do schedules se existir
                $lookup[$class][$place->id] = $schedules[$class.'-'.$place->id]
                    ??[
                        "class_number"=>$class,
                        "place_id"=>$place->id,
                        "shift"=>"MANHA"
                    ];
            }
        }//Fim do foreach
        return view('Scheduling/index', ['schedules'=>$lookup, "places"=>$places]);
        return $lookup;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        try {
            //Criando o objeto e definindo os seus atributos
            $scheduling = new Scheduling();
            $scheduling->date = $request->date;
            $scheduling->class_number = $request->class_number;
            $scheduling->shift = $request->shift;
            $scheduling->place_id = $request->place_id;
            $scheduling->user_id = $request->user_id;

            //Chama a função que salva no banco de dados
            $scheduling->save();

            //Emitir o broadcast de agendamento para todos os ouvintes
            event(new SchedulingCreated($scheduling));

            //Redireciona para a página principal
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json([
                'success'=> false,
                'message'=> $e->getMessage()
            ], 500);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Scheduling $scheduling)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Scheduling $scheduling)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Scheduling $scheduling)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Scheduling $scheduling)
    {
        //
    }
}
