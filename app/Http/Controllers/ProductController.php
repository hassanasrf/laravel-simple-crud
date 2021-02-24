<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use File;
class ProductController extends Controller
{
    public function index(){

        $products = Product::orderBy('id','DESC')->get();
        return view('products.index')->with(compact('products'));
        
    }

    public function create(){

        return view('products.create');
    }

    public function show($id){
        //
    }

    public function store(Request $request){

        $request->validate([
            'name'    =>  'required',
            'price'   => 'required',
            'image'   => 'required',
            'description'   => 'required'
        ]);

        $store_image = null;
        if (request()->File('image')) 
        {
            $file = request()->File('image');
            $store_image = md5($file->getClientOriginalName()) . time() . "." . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $store_image);
        } 

        $form_data = array(
            'name'       =>   $request->name,
            'price'       =>   $request->price,
            'image'       =>   $store_image,
            'description'       =>   $request->description,
        );

        Product::create($form_data);

        return redirect('products')->with('success', 'Product Added successfully.');
        
    }

    public function edit($id){
        
        $product= Product::findOrFail($id);
        return view('products.edit')->with(compact('product'));
    }

    public function update(Request $request, $id){

        $product= Product::find($id);

        $currentImage = $product->image;

        $update_image = null;
        if (request()->File('image')) 
        {
            $file = request()->File('image');
            $update_image = md5($file->getClientOriginalName()) . time() . "." . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $update_image);
        }    

        $product->update([
            'name'    =>  $request->name,
            'price'    =>  $request->price,
            'image' => ($update_image) ? $update_image : $currentImage,
            'description'    =>  $request->description,
        ]);
        if ($update_image) {
            File::delete(public_path('/images/' . $currentImage));
        }

        return redirect('products')->with('success', 'Product is successfully updated');

}

    public function destroy($id)
    {
        $product = Product::where('id' ,$id)->first();

        //remove image from local directory
        $image_path = public_path().'/images/'.$product->image;
        unlink($image_path);
        
        $product->delete();
        return redirect('products')->with('success', 'Product is successfully deleted');
        
    }
}
