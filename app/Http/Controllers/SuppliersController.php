<?php

namespace App\Http\Controllers;

use App\Models\Suppliers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SuppliersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = Suppliers::all();

        if ($suppliers->isEmpty()) {
            $data = [
                'mensaje' => 'No hay proveedores disponibles.',
                // 'suppliers' => [],
                'status' => 404 // Código adecuado para "No encontrado"
            ];

            return response()->json($data, 404);
        }

        // Si hay proveedores, devuélvelos con el mensaje adecuado
        $data = [
            'mensaje' => 'proveedores obtenidos con éxito.',
            'suppliers' => $suppliers,
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
            'email'=>'required |email|unique:suppliers',
            'phone'=>'required | digits:10',
            'address' => 'required | max:255',
            'country' => 'required | max:100',
            // 'status' => 'required | in:active,inactive',

        ]);


        if ($validator->fails()) {

            $data = [

                "message" => " error al crear registro",
                "status"  => 400
            ];

            return response()->json($data, 400);
        }

        $suppliers = Suppliers::create([
            'name' => $request->name,
            'email'=> $request->email,
            'phone'=>$request->phone,
            'address' => $request->address,
            'country' => $request->country,
            // 'status' => $request->status,
        ]);

        if (!$suppliers) {

            $data = [

                "message" => " N0 se cre0 categ0ria",
                "status"  => 500
            ];


            return response()->json($data, 500);
        }

        $data = [

            "message" => " Proveedor creado",
            "suppliers"  => $suppliers,
            "status"  => 201
        ];

        return response()->json($data, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $suppliers = Suppliers::find($id);

        if (!$suppliers) {
            $data = [
                'message' => 'No se encotro registro',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'suppliers' => $suppliers,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Suppliers $suppliers)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $suppliers = Suppliers::find($id);


        if (!$suppliers) {
            $data = [

                'message' => 'No se encotro registro',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'max:255',
            'email'=>'email|unique:suppliers,email,'.$id,
            'phone'=>' digits:10',
            'address' => 'max:255',
            'country' => 'max:100',
            // 'status' => 'in:active,inactive',

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

          $suppliers->name = $request->name;
        }


        if($request->has('email')){

            $suppliers->email = $request->email;
          }


          if($request->has('phone')){

            $suppliers->phone = $request->phone;
          }


          if($request->has('address')){

            $suppliers->address = $request->address;
          }


          if($request->has('country')){

            $suppliers->country = $request->country;
          }

        //   if($request->has('status')){

        //     $suppliers->status = $request->status;
        //   }

       

        $suppliers->save();

     
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
           
        $suppliers = Suppliers::find($id);

        if(!$suppliers){
        $data=[
          'message' =>'error, No se pudo eliminar',
          'status' => 404

        ];
        return response()->json($data, 404);
        } 

        $suppliers->delete();

        $data=[
            'message' =>'proveedor eliminado',
            'status' => 200
  
          ];
          return response()->json($data,200);

    }
}
