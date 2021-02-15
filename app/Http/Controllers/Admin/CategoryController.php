<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Category;
use File;

class CategoryController extends Controller
{

	   	public function index()
	    {
	    	$categories = category::orderBy('name')->paginate(10);
	    	return view('admin.categories.index')->with(compact('categories')); // listado
	    }

	    public function create()
	    {
	    	return view('admin.categories.create'); // formulario de registro
	    }

	    public function store(Request $request)
	    {
	        // validar
	        $this->validate($request, Category::$rules, Category::$messages);

	    	//registrar la nueva categoría en la base de datos
	    	$category = Category::create($request->only('name', 'description'));

	    	if ($request->hasFile('image')) {
	    		$file = $request->file('image');
	    		$path = public_path() . '/images/categories';
	    		$fileName = uniqid() . '-' . $file->getClientOriginalName();
	    		$moved = $file->move($path, $fileName);

	    		// update category
	    		if ($moved) {
	    			$category->image = $fileName;
	    			$category->save(); // UPDATE
	    		}
	    	}

	        return redirect('/admin/categories');
	    }
	    public function edit(Category $category)
	    {
	    	return view('admin.categories.edit')->with(compact('category')); // formulario de edición
	    }

	    public function update(Request $request, Category $category)
	    {
	                // validar
	        $this->validate($request, Category::$rules, Category::$messages);

	    	//registrar el nuevo producto en la base de datos
	        $category->update($request->only('name', 'description'));

	        if ($request->hasFile('image')) {
	    		$file = $request->file('image');
	    		$path = public_path() . '/images/categories';
	    		$fileName = uniqid() . '-' . $file->getClientOriginalName();
	    		$moved = $file->move($path, $fileName);

	    		// update category
	    		if ($moved) {
	    			$previousPath = $path . '/' . $category->image;

	    			$category->image = $fileName;
	    			$saved = $category->save(); // UPDATE

	    			if ($saved)
	    				File::delete($previousPath);
	    		}
	    	}

	    	return redirect('/admin/categories');

	    }

	    public function destroy(Category $category)
	    {
	        $category->delete(); //DELETE

	        return back();


	  	}
}
