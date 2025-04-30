<?php

namespace App\Http\Controllers;

use App\Models\categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoriesController extends Controller
{


    public function __construct(){

        // $this->middleware('auth:sanctum');

        $this->middleware('can:crear_categorias',[
        'only'=>[
           'store'
        ]
        ]);
   
        $this->middleware('can:ver_categorias',[
           'only'=>[
              'index', 'show'
           ]
           ]);
   
           $this->middleware('can:editar_categorias',[
               'only'=>[
                  'update','updatePartial'
               ]
               ]);
   
               $this->middleware('can:elimnar_categorias',[
                   'only'=>[
                      'destroy'
                   ]
                   ]);
   
   }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtén todas las categorías
        $categories = categories::all();

        // Si no hay categorías, devuelve un mensaje indicando esto
        if ($categories->isEmpty()) {
            $data = [
                'mensaje' => 'No hay categorías disponibles.',
                // 'categories' => [],
                'status' => 404 // Código adecuado para "No encontrado"
            ];

            return response()->json($data, 404);
        }

        // Si hay categorías, devuélvelas con el mensaje adecuado
        $data = [
            'mensaje' => 'Categorías obtenidas con éxito.',
            'categories' => $categories,
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
        $validator = Validator::make($request->all(), [
            'name' => 'required | max:255',
        ]);


        if ($validator->fails()) {

            $data = [

                "message" => " error al crear registro",
                "status"  => 400
            ];

            return response()->json($data, 400);
        }

        $categories = categories::create([
            'name' => $request->name
        ]);

        if (!$categories) {

            $data = [

                "message" => " N0 se cre0 categ0ria",
                "status"  => 500
            ];


            return response()->json($data, 500);
        }

        $data = [

            "message" => " Categoria creada crear",
            "categories"  => $categories,
            "status"  => 201
        ];

        return response()->json($data, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $categories = categories::find($id);

        if (!$categories) {
            $data = [
                'message' => 'No se encotro registro',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'categories' => $categories,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $categories = categories::find($id);

        if (!$categories) {
            $data = [

                'message' => 'No se encotro registro',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required | max:255',
        ]);

        if ($validator->fails()) {
            $data = [
                'menssage' => 'Error en la validacion',
                'errors' => $validator->errors(),
                'status' => 400

            ];
            return response()->json($data, 400);
        }


        $categories->name = $request->name;

        $categories->save();

        $data = [
            'message' => 'categoria actualizada',
            'ststus' => 200
        ];

        return response()->json($data, 200);
    }



    public function updatePartial(Request $request, string $id)
    {

        $categories = categories::find($id);


        if (!$categories) {
            $data = [

                'message' => 'No se encotro registro',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [

            'name' => 'max: 255',

        ]);

        if($validator-> fails()){
            $data = [
                'menssage' => 'Error en la validacion',
                'errors' => $validator->errors(),
                'status' => 400

            ];
            return response()->json($data, 400);

        }


        if($request->has('name')){

          $categories->name = $request->name;
        }

        $categories->save();

     
        $data = [
            'message' => 'categoria actualizada',
            'ststus' => 200
        ];

        return response()->json($data, 200);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
        $categories = categories::find($id);

        if(!$categories){
        $data=[
          'message' =>'error, No se pudo eliminar',
          'status' => 404

        ];
        return response()->json($data, 404);
        } 

        $categories->delete();

        $data=[
            'message' =>'Categoria eliminada',
            'status' => 200
  
          ];
          return response()->json($data,200);

    }
}
