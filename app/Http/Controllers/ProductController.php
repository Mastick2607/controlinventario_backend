<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{

public function __construct(){

     $this->middleware('can:crear_productos',[
     'only'=>[
        'store'
     ]
     ]);

     $this->middleware('can:ver_productos',[
        'only'=>[
           'index', 'show','lowStock','totalStock'
        ]
        ]);

        $this->middleware('can:editar_productos',[
            'only'=>[
               'update','updatePartial'
            ]
            ]);

            $this->middleware('can:elimnar_productos',[
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
        $products = Product::all();

        // Si no hay categorías, devuelve un mensaje indicando esto
        if ($products->isEmpty()) {
            $data = [
                'mensaje' => 'No hay productos disponibles.',
                // 'products' => [],
                'status' => 404 // Código adecuado para "No encontrado"
            ];

            return response()->json($data, 404);
        }

        // Si hay categorías, devuélvelas con el mensaje adecuado
        $data = [
            'mensaje' => 'productos obtenidos con éxito.',
            'products' => $products,
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
            'description' => 'required | max:300',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);


        if ($validator->fails()) {

            $data = [

                "message" => " error al crear registro",
                "status"  => 400
            ];

            return response()->json($data, 400);
        }

        $products = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'category_id' => $request->category_id,
        ]);

        if (!$products) {

            $data = [

                "message" => " N0 se cre0 categ0ria",
                "status"  => 500
            ];


            return response()->json($data, 500);
        }

        $data = [

            "message" => " Categoria creada crear",
            "categories"  => $products,
            "status"  => 201
        ];

        return response()->json($data, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $products = Product::find($id);

        if (!$products) {
            $data = [
                'message' => 'No se encotro registro',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'product' => $products,
            'status' => 200
        ];
        return response()->json($data, 200);
    }


    public function lowStock()
    {

        $products = Product::with('category')->where('quantity', '<', '10')->get();

        if ($products->isEmpty()) {
            $data = [
                'message' => 'No se encotro pocas unidades',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'products' => $products,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function totalStock()
    {
      $totalStock = Product::sum('quantity');

      if($totalStock == 0){
      
        $data=[
        'message'=>'No hay productos en total',
        'status' =>404

        ];
        return response()->json($data, 404);
    }

    $data = [
        'mensaje' => 'Total de stock obtenidaos con éxito.',
        'totalStock' => $totalStock,
        'status' => 200 
    ];

    return response()->json($data, 200);

    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $products = Product::find($id);

        if (!$products) {
            $data = [

                'message' => 'No se encotro registro',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'sku' => 'required | max:255',
            'name' => 'required | max:255',
            'description' => 'required | max:300',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($validator->fails()) {
            $data = [
                'menssage' => 'Error en la validacion',
                'errors' => $validator->errors(),
                'status' => 400

            ];
            return response()->json($data, 400);
        }

        $products->sku = $request->sku;
        $products->name = $request->name;
        $products->description = $request->description;
        $products->quantity = $request->quantity;
        $products->price = $request->price;
        $products->category_id = $request->category_id;

        $products->save();

        $data = [
            'message' => 'producto actualizado',
            'status' => 200
        ];

        return response()->json($data, 200);
    }


    public function updatePartial(Request $request, string $id)
    {

        $products = Product::find($id);


        if (!$products) {
            $data = [

                'message' => 'No se encotro registro',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'sku' => 'required | max:255',
            'name' => 'max:255',
            'description' => 'max:300',
            'quantity' => 'integer|min:1',
            'price' => 'numeric|min:0',
            'category_id' => 'exists:categories,id',
        ]);
        if ($validator->fails()) {
            $data = [
                'menssage' => 'Error en la validacion',
                'errors' => $validator->errors(),
                'status' => 400

            ];
            return response()->json($data, 400);
        }

        if ($request->has('sku')) {

            $products->sku = $request->sku;
        }

        if ($request->has('name')) {

            $products->name = $request->name;
        }



        if ($request->has('description')) {

            $products->description = $request->description;
        }


        if ($request->has('quantity')) {

            $products->quantity = $request->quantity;
        }

        if ($request->has('price')) {

            $products->price = $request->price;
        }

        if ($request->has('category_id')) {

            $products->category_id = $request->category_id;
        }

        $products->save();


        $data = [
            'message' => 'producto actualizados',
            'ststus' => 200
        ];

        return response()->json($data, 200);
    }
    /**
     * Remove the specified resource from storage.
m     */
    public function destroy(string $id)
    {
        $products = Product::find($id);

        if(!$products){
        $data=[
          'message' =>'error, No se pudo eliminar',
          'status' => 404

        ];
        return response()->json($data, 404);
        } 

        $products->delete();

        $data=[
            'message' =>'Producto eliminado',
            'status' => 200
  
          ];
          return response()->json($data,200);

         
    }
}
