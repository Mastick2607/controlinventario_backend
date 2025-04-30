<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Movements;
use App\Models\sales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function __construct(){

      $this->middleware('can:crear_salida',[
      'only'=>[
         'store'
      ]
      ]);
 
      $this->middleware('can:ver_salida',[
         'only'=>[
            'index', 'show','totalSales','totalRevenue','latestSales','getSalesByProduct'
         ]
         ]);
 
         $this->middleware('can:editar_salida',[
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
        $sales = sales::with(['product','customer'])->get();

      if  ($sales->isEmpty()){
      
            $data=[
            'message'=>'No se logro encontrar registro',
            'status' =>404

            ];
            return response()->json($data, 404);
        }

         // Si hay ventas, devuélvelas con el mensaje adecuado
         $data = [
            'mensaje' => 'Ventas obtenidas con éxito.',
            'sales' => $sales,
            'status' => 200 
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
        $validator =Validator::make($request->all(),[
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required|integer|min:1',
        'sale_price' =>'required|numeric|min:0',
        'subtotal' => ' required|numeric|min:0',
        'iva' => ' required|numeric|min:0',
        'total_price' => 'required|numeric|min:0',
        'sale_date' => 'required|date',
        'customer_id' => 'required|exists:customers,id',
        'transfer_type'=>'required|max:255',
        'document_type'=>'required|max:255',
        'document_number' => 'required|max:255',
        ]);
        
        if ($validator->fails()) {

            $data = [

                "message" => "error al crear Venta",
              "errors" => $validator->errors(),
                "status"  => 400
            ];

            return response()->json($data, 400);
        }

        $product = Product::find($request->product_id);
 
        //calcular el precio subtotal

        $subtotal =  $request->sale_price*$request->quantity;
        $iva = $subtotal * 0.19; // IVA del 19%
        $total_price = $subtotal + $iva;
     

        if( $product->quantity < $request->quantity){

            return response()->json(['error' => 'Stock insuficiente'], 400);
        }

        $sales = sales::create([
        'product_id' => $request->product_id,
        'quantity' => $request->quantity,
        'sale_price' =>$request->sale_price,
        'subtotal' =>   $subtotal,
        'iva' => $iva,
        'total_price' =>  $total_price,
        'sale_date' =>$request->sale_date,
        'customer_id' => $request->customer_id,
        'transfer_type'=>$request->transfer_type,
        'document_type'=>$request->document_type,
        'document_number' =>$request->document_number,

        ]);

        $movement = Movements::create([
          'product_id' => $request->product_id,
          'sale_id' =>  $sales->id,
          'quantity' => $request->quantity,
          'unit_price' => $request->sale_price,
          'subtotal_movements' => $subtotal,
          'iva' => $iva,
          'totalprice' => $total_price,
          'transfer_type'=> $request->transfer_type,
          'document_type'=>$request->document_type,
          'document_number' => $request->document_number,
           'movement_date' => $request->sale_date,
      ]);





        if (!$sales) {
       


            $data = [

                "message" => " No se creo 'la venta'",
                "status"  => 500
            ];


            return response()->json($data, 500);
        }else{
            $product->decrement('quantity',$request->quantity );

        }

        $data = [

            "message" => " Categoria creada crear",
            "sales"  => $sales,
            "movement"   => $movement,
            "status"  => 201
        ];

        return response()->json($data, 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
      $sales = sales::with(['product','customer'])->find($id);

      if(!$sales){
      
        $data=[
        'message'=>'No se logro encontrar registro en expecifico',
        
        'status' =>404

        ];
        return response()->json($data, 404);
    }

    $data = [
        'mensaje' => 'Venta obtenida con éxito.',
        'sale' => $sales,
        'status' => 200 
    ];

    return response()->json($data, 200);

    }

    public function totalSales()
    {
      $totalsales = sales::count();

      if($totalsales === 0){
      
        $data=[
        'message'=>'No hay ventas registradas',
        'status' =>404

        ];
        return response()->json($data, 404);
    }

    $data = [
        'mensaje' => 'Total de ventas obtenidas con éxito.',
        'totalsales' => $totalsales,
        'status' => 200 
    ];

    return response()->json($data, 200);

    }


    public function totalRevenue()
    {
      $totalRevenue = sales::sum('total_price');

      if($totalRevenue == 0){
      
        $data=[
        'message'=>'No hay ingresos',
        'status' =>404

        ];
        return response()->json($data, 404);
    }

    $data = [
        'mensaje' => 'Total de ventas obtenidas con éxito.',
        'totalRevenue' => $totalRevenue,
        'status' => 200 
    ];

    return response()->json($data, 200);

    }


    

    public function latestSales()
    {
      $sales = sales::with('product')
      ->latest()
      ->take(3)
      ->get();

      if(!$sales){
      
        $data=[
        'message'=>'No se logro encontrar las ultimas ventas',
        
        'status' =>404

        ];
        return response()->json($data, 404);
    }

    $data = [
        'mensaje' => 'Ulltimas venta obtenida con éxito.',
        'sales' => $sales,
        'status' => 200 
    ];

    return response()->json($data, 200);

    }





    /**
     * Show the form for editing the specified resource.
     */
    public function edit(sales $sales)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $sales = sales::find($id);

        $validator =Validator::make($request->all(),[
            'product_id' => 'exists:products,id',
            'quantity' => 'integer|min:1',
            'sale_price' =>'numeric|min:0',
            'subtotal' => 'numeric|min:0',
            'iva' => ' numeric|min:0',
            'total_price' => 'numeric|min:0',
            'sale_date' => 'date',
            'customer_id' => 'exists:customers,id',
            'transfer_type'=>'max:255',
            'document_type'=>'max:255',
            'document_number' => 'max:255',
            ]);
            if ($validator->fails()) {
    
                $data = [
    
                    "message" => " error al crear Venta",
                  "errors" => $validator->errors(),
                    "status"  => 400
                ];
    
                return response()->json($data, 400);
            }

            $movements = Movements::where('sale_id', $id)->first();


            if($request->has('product_id')){

                $sales->product_id = $request->product_id;
                $movements->product_id = $request->product_id;
              }
              
              if($request->has('sale_price')){

                $sales->sale_price = $request->sale_price;
                $movements->unit_price = $request->sale_price;

              
              }

              if($request->has('subtotal')){

                $sales->subtotal = $request->subtotal;
                $movements->subtotal = $request->subtotal;

              }

              if($request->has('iva')){

                $sales->iva = $request->iva;
                $movements->iva = $request->iva;

              }
         
              if($request->has('total_price')){

                $sales->total_price = $request->total_price;
                $movements->total_price = $request->total_price;

              }
              
            if($request->has('quantity')){

                // $product = Product::find($sales->product_id);
                $sales->quantity = $request->quantity;
                             
                // $sales->total_price =  $product->price * $request->quantity;
                $subtotal =  $request->sale_price*$request->quantity;
                $iva = $subtotal * 0.19; // IVA del 19%
                $total_price = $subtotal + $iva;
    
                $sales->$subtotal =$subtotal;
                $sales->$iva =$iva;
                $sales->total_price = $total_price;
              
                $movements->quantity = $request->quantity;

              }

            if($request->has('sale_date')){

                $sales->sale_date = $request->sale_date;
                $movements->movement_date = $request->sale_date;
  
              }
            
              if($request->has('customer_id')){

                $sales->customer_id = $request->customer_id;
              }
              if($request->has('transfer_type')){

                $sales->transfer_type = $request->transfer_type;
                $movements->transfer_type = $request->transfer_type;

            
              }
              if($request->has('document_type')){

                $sales->document_type = $request->document_type;
                $movements->document_type = $request->document_type;

              }

              if($request->has('document_number')){

                $sales->document_number = $request->document_number;
                $movements->document_number = $request->document_number;
              
              
              }
            $sales->save();
            $movements->save();



     $data = [
            'message' => 'venta actualizada',
            'ststus' => 200
        ];

        return response()->json($data, 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       
        
        $sales = sales::find($id);

        if(!$sales){
      
            $data=[
            'message'=>'No se logro encontrar registro en expecifico',
            
            'status' =>404
    
            ];
            return response()->json($data, 404);
        }

        $sales->delete();

        $data = [
            'message' => 'venta eliminada',
            'ststus' => 200
        ];

        return response()->json($data, 200);        

    }

    public function getSalesByProduct(string $productId)
    {
        // Verificar que el producto exista
        $product = Product::find($productId);


        if(!$product){
      
            $data=[
            'message'=>'No se logro encontrar registro el producto en expecifico',
            
            'status' =>404
    
            ];
            return response()->json($data, 404);
        }

        // Obtener las ventas del producto
        $sales = sales::with('product')-> where('product_id', $productId)->get();

        return response()->json($sales, 200);
    }
    
}
