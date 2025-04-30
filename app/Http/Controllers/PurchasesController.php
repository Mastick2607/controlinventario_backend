<?php

namespace App\Http\Controllers;

use App\Models\Movements;
use App\Models\Product;
use App\Models\Purchases;
use App\Models\Suppliers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class PurchasesController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function __construct(){

        $this->middleware('can:crear_ingreso',[
        'only'=>[
           'store'
        ]
        ]);
   
        $this->middleware('can:ver_ingreso',[
           'only'=>[
              'index', 'show'
           ]
           ]);
   
           $this->middleware('can:editar_ingreso',[
               'only'=>[
                  'update','updatePartial'
               ]
               ]);
   
               $this->middleware('can:elimnar_salida',[
                   'only'=>[
                      'destroy'
                   ]
                   ]);
   
   } 
     
    public function index()
    {
        $purchases = DB::table('purchases')
        ->join('suppliers', 'purchases.suppliers_id', '=', 'suppliers.id')
        ->join('products', 'purchases.product_id', '=', 'products.id')
        ->select(
            'purchases.*', 
            'suppliers.name as supplier_name', 
            'products.name as product_name'
        )
        ->get();

        if ($purchases->isEmpty()) {
            $data = [
                'mensaje' => 'No hay Compras disponibles.',
                // 'purchases' => [],
                'status' => 404 // Código adecuado para "No encontrado"
            ];

            return response()->json($data, 404);
        }

        // Si hay proveedores, devuélvelos con el mensaje adecuado
        $data = [
            'mensaje' => 'Compras obtenidoas con éxito.',
            'purchases' => $purchases,
            'status' => 200 // Código adecuado para éxito
        ];

        return response()->json($data, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       
    }

    /*
     * Store a newly created resource in storage.
     */
    
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'product_id' =>'required|exists:products,id',
            'suppliers_id'=> 'required|exists:suppliers,id',
            'transfer_type'=>' required|max:255',
            'document_type'=>' required|max:255',
            'document_number' => ' required|max:255',
            'quantity' => ' required|integer|min:1',
            'purchase_price' => ' required|numeric|min:0',
            'subtotal' => ' required|numeric|min:0',
            'iva' => ' required|numeric|min:0',
            'total_price' => ' required|numeric|min:0',
            'entry_date' => ' required|date',
        ]);


        if ($validator->fails()) {

            $data = [

                "message" => " error al crear registro",
                "status"  => 400
            ];

            return response()->json($data, 400);
        }


        $product = Product::find( $request->product_id);

        // Calcular subtotal, IVA y total
        // $subtotal =$request->purchase_price * $request->quantity;
        // $iva = $subtotal * 0.19; // IVA del 19%
        // $total_price = $subtotal + $iva;


        $purchases = Purchases::create([
            'product_id' => $request->product_id,
            'suppliers_id'=> $request->suppliers_id,
            'transfer_type'=> $request->transfer_type,
            'document_type'=>$request->document_type,
            'document_number' => $request->document_number,
            'quantity' => $request->quantity,
            'purchase_price' => $request->purchase_price,
            'subtotal' =>$request->subtotal,
            'iva' => $request->iva,
            'total_price' =>$request->total_price,
            'entry_date' => $request->entry_date,
        ]);

        $movement = Movements::create([
            'product_id' => $request->product_id,
            'purchase_id' =>  $purchases->id,
            'quantity' => $request->quantity,
            'unit_price' =>  $request->purchase_price,
            'subtotal_movements' => $request->subtotal,
            'iva' => $request->iva,
            'totalprice' => $request->total_price,
            'transfer_type'=> $request->transfer_type,
            'document_type'=>$request->document_type,
            'document_number' => $request->document_number,
            'movement_date' => $request->entry_date,
        ]);

        

        if (!$purchases) {

            $data = [

                "message" => " N0 se cre0 c0mpra",
                "status"  => 500
            ];


            return response()->json($data, 500);
        }

           // Actualizar el stock del producto
           $product->increment('quantity',$request->quantity);

        $data = [

            "message" => " Compra creada",
            "purchases"  => $purchases,
            "movement" => $movement,
            "status"  => 201
        ];

        return response()->json($data, 201);
    }

    /**
     * Display the specified resource.
     */
    
    public function show(string $id)
    {
$purchases = DB::table('purchases')
    ->join('suppliers', 'purchases.suppliers_id', '=', 'suppliers.id')
    ->join('products', 'purchases.product_id', '=', 'products.id')
    ->select(
        'purchases.*', 
        'suppliers.name as supplier_name', 
        'products.name as product_name'
    )
    ->where('purchases.id', $id) 
    ->first(); // Obtener solo un

        if (!$purchases) {
            $data = [
                'message' => 'No se encotro registro',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'purchases' => $purchases,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Purchases $purchases)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $purchases = Purchases::find($id);

      


        if (!$purchases) {
            $data = [

                'message' => 'No se encotro registro',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'product_id' => 'exists:products,id',
            'suppliers_id'=> 'exists:suppliers,id',
            'transfer_type'=>'max:255',
            'document_type'=>'max:255',
            'document_number' => 'max:255',
            'quantity' => 'required |integer|min:1',
            'purchase_price' => 'required | numeric|min:0',
            'subtotal' => 'required | numeric|min:0',
            'iva' => 'required | numeric|min:0',
            'total_price' => 'required | numeric|min:0',
            'entry_date' => 'required |date',
        ]);
        if($validator-> fails()){
            $data = [
                'menssage' => 'Error en la validacion',
                'errors' => $validator->errors(),
                'status' => 400

            ];
            return response()->json($data, 400);

        }

// 
  $movements = Movements::where('purchase_id', $id)->first();


        if($request->has('product_id')){

          $purchases->product_id = $request->product_id;
          $movements->product_id = $request->product_id;

        }

        if($request->has('suppliers_id')){

            $purchases->suppliers_id = $request->suppliers_id;
          }

        
        if($request->has('transfer_type')){

            $purchases->transfer_type = $request->transfer_type;
            $movements->transfer_type = $request->transfer_type;
  
        } 


          if($request->has('document_type')){

            $purchases->document_type = $request->document_type;
            $movements->document_type = $request->document_type;

        }


          if($request->has('document_number')){

            $purchases->document_number = $request->document_number;
            $movements->document_number = $request->document_number;
  
        }


          if($request->has('quantity')){

            $purchases->quantity = $request->quantity;
            $movements->quantity = $request->quantity;

        }

          if($request->has('purchase_price')){

            $purchases->purchase_price = $request->purchase_price;
            $movements->unit_price = $request->purchase_price;
 
        }

          if($request->has('subtotal')){

            $purchases->subtotal = $request->subtotal;
            $movements->subtotal_movements = $request->subtotal;

        }

          if($request->has('iva')){

            $purchases->iva = $request->iva;
            $movements->iva = $request->iva;

          }
       

          if($request->has('total_price')){

            $purchases->total_price = $request->total_price;
            $movements->total_price = $request->total_price;

        }
       

          if($request->has('entry_date')){

            $purchases->entry_date = $request->entry_date;
            $movements->movement_date = $request->entry_date;

          }
       

        $purchases->save();
        $movements->save();
     
        $data = [
            'message' => 'C0mpra actualizada',
            'ststus' => 200
        ];

        return response()->json($data, 200); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $purchases = Purchases::find($id);

        if(!$purchases){
        $data=[
          'message' =>'error, No se pudo eliminar',
          'status' => 404

        ];
        return response()->json($data, 404);
        } 

        $purchases->delete();

        $data=[
            'message' =>'C0mpra eliminado',
            'status' => 200
  
          ];
          return response()->json($data,200);
    }
}
