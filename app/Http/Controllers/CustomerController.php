<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function __construct(){

        $this->middleware('can:crear_cliente',[
        'only'=>[
           'store'
        ]
        ]);
   
        $this->middleware('can:ver_cliente',[
           'only'=>[
              'index', 'show'
           ]
           ]);
   
           $this->middleware('can:editar_cliente',[
               'only'=>[
                  'update','updatePartial'
               ]
               ]);
   
               $this->middleware('can:elimnar_cliente',[
                   'only'=>[
                      'destroy'
                   ]
                   ]);
   
   }     


    public function index()
    {
        $customer = Customer::all();

        if ($customer->isEmpty()) {
            $data = [
                'mensaje' => 'No hay proveedores disponibles.',
                // 'customer' => [],
                'status' => 404 // Código adecuado para "No encontrado"
            ];

            return response()->json($data, 404);
        }

        // Si hay proveedores, devuélvelos con el mensaje adecuado
        $data = [
            'mensaje' => 'Clientes obtenidos con éxito.',
            'customer' => $customer,
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
            'phone'=>'required | digits:10',
            'email'=>'required |email|unique:customers',
            'address' => 'required | max:255',
        ]);


        if ($validator->fails()) {

            $data = [

                "message" => " error al crear registro",
                "status"  => 400
            ];

            return response()->json($data, 400);
        }

        $customer = Customer::create([
            'name' => $request->name,
            'phone'=>$request->phone,
            'email'=> $request->email,
           'address' => $request->address,
          
        ]);

        if (!$customer) {

            $data = [

                "message" => " N0 se cre0 el cliente",
                "status"  => 500
            ];


            return response()->json($data, 500);
        }

        $data = [

            "message" => " Cliente creado",
            "customer"  => $customer,
            "status"  => 201
        ];

        return response()->json($data, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            $data = [
                'message' => 'No se encotro registro',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'customer' => $customer,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
     
        $customer = Customer::find($id);


        if (!$customer) {
            $data = [
                'message' => 'No se encotro registro',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'max:255',
            'phone'=>' digits:10',
            'email'=>'email|unique:customers,email,'.$id,
            'address' => 'max:255',
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

          $customer->name = $request->name;
        }


        if($request->has('email')){

            $customer->email = $request->email;  
        }


          if($request->has('phone')){

            $customer->phone = $request->phone;
          }
    
          if($request->has('address')){

            $customer->address = $request->address;
          }

        $customer->save();
        $data = [
            'message' => 'Cliente actualizado',
            'status' => 200
        ];

        return response()->json($data, 200);    
    }

    /**
     * Remove the specified resource from storage.
     */
    
    public function destroy(string $id)
    {
        $customer = Customer::find($id);

        if(!$customer){
        $data=[
          'message' =>'error, No se pudo eliminar',
          'status' => 404

        ];
        return response()->json($data, 404);
        } 

        $customer->delete();

        $data=[
            'message' =>'Cliente eliminado',
            'status' => 200
  
          ];
          return response()->json($data,200);

    }
}
