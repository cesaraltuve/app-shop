<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Product;
use App\Category;

class ProductController extends Controller
{
    public function index()
    {
    	$products = product::paginate(10);
    	return view('admin.products.index')->with(compact('products')); // listado
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
    	return view('admin.products.create')->with(compact('categories')); // formulario de registro
    }

    public function store(Request $request)
    {
        // validar
        $messages = [
            'name.required' => 'Es necesario ingresar un nombre del producto.',
            'name.min' => 'El nombre del producto debe tener al menos tres caracteres.',
            'description.required' => 'La descripción corta es un campo obligatorio.',
            'description.max' => 'La descripción corta solo admite hasta 200 caracteres. ',
            'price.required' => 'Es obligatorio definir un precio para el producto.',
            'price.numeric' => 'Ingrese un precio válido.',
            'price.min' => 'No se admiten valores negativos en el precio.'
        ];
        $rules = [
            'name' => 'required|min:3',
            'description' => 'required|max:200',
            'price' => 'required|numeric|min:0'
        ];
        $this->validate($request, $rules, $messages);

    	//registrar el nuevo producto en la base de datos
    	$product = new Product();
    	$product->name = $request->input('name');
    	$product->description = $request->input('description');
    	$product->price = $request->input('price');
    	$product->long_description = $request->input('long_description');
        $product->Category_id = $request->category_id;
    	$product->save(); //INSERT

    	return redirect('/admin/products');


    }
    public function edit($id)
    {
    	$categories = Category::orderBy('name')->get();
        $product = Product::find($id);
    	return view('admin.products.edit')->with(compact('product', 'categories')); // formulario de edición
    }

    public function update(Request $request, $id)
    {
                // validar
        $messages = [
            'name.required' => 'Es necesario ingresar un nombre del producto.',
            'name.min' => 'El nombre del producto debe tener al menos tres caracteres.',
            'description.required' => 'La descripción corta es un campo obligatorio.',
            'description.max' => 'La descripción corta solo admite hasta 200 caracteres. ',
            'price.required' => 'Es obligatorio definir un precio para el producto.',
            'price.numeric' => 'Ingrese un precio válido.',
            'price.min' => 'No se admiten valores negativos en el precio.'
        ];
        $rules = [
            'name' => 'required|min:3',
            'description' => 'required|max:200',
            'price' => 'required|numeric|min:0'
        ];
        $this->validate($request, $rules, $messages);

    	//registrar el nuevo producto en la base de datos
    	$product = Product::find($id);
    	$product->name = $request->input('name');
    	$product->description = $request->input('description');
    	$product->price = $request->input('price');
    	$product->long_description = $request->input('long_description');
                $product->Category_id = $request->category_id;
    	$product->save(); //UPDATE

    	return redirect('/admin/products');


    }

    public function destroy($id)
    {
        //registrar el nuevo producto en la base de datos
        $product = Product::find($id);
        $product->delete(); //DELETE

        return back();


    }
}
