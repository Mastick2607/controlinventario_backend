<?php

namespace App\Http\Controllers;

use App\Models\Movements;
use Illuminate\Http\Request;

class MovementsController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function __construct(){

        $this->middleware('can:crear_movimento',[
        'only'=>[
           'store'
        ]
        ]);
   
        $this->middleware('can:ver_movimento',[
           'only'=>[
              'index', 'show'
           ]
           ]);
   
           $this->middleware('can:editar_movimento',[
               'only'=>[
                  'update','updatePartial'
               ]
               ]);
   
               $this->middleware('can:elimnar_movimento',[
                   'only'=>[
                      'destroy'
                   ]
                   ]);
   
   } 
     
    public function index()
    {
        $movements = Movements::with(['product'])->get();

        if ($movements->isEmpty()) {
            $data = [
                'mensaje' => 'No hay Movimientos disponibles.',
                // 'movements' => [],
                'status' => 404 // Código adecuado para "No encontrado"
            ];

            return response()->json($data, 404);
        }

        // Si hay proveedores, devuélvelos con el mensaje adecuado
        $data = [
            'mensaje' => 'movimentos obtenidos con éxito.',
            'movements' => $movements,
            'status' => 200 // Código adecuado para éxito
        ];

        return response()->json($data, 200);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $movement = Movements::with(['product'])->find($id);

        if (!$movement) {
            $data = [
                'message' => 'No se encotro registro',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'movement' => $movement,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Movements $movements)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Movements $movements)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    

        $movement = Movements::find($id);

        if(!$movement){
        $data=[
          'message' =>'error, No se pudo eliminar',
          'status' => 404

        ];
        return response()->json($data, 404);
        } 

        $movement->delete();

        $data=[
            'message' =>'movimento eliminado',
            'status' => 200
  
          ];
          return response()->json($data,200);
    }
}
