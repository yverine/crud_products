<?php

namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return Product::all();
    }

    public function show($id)
    {
        return Product::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        if($request->get('image_name'))
        {
            $image = $request->get('image_name');
            $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            //mkdir(public_path('images/').$name, 777, true);
            \Image::make($request->get('image_name'))->resize(400, 300)->save(public_path('images/').$name);
        }
        $product->update([
            'name_product' => $request->name_product,
            'description' => $request->description,
            'image_name' => $name
        ]);

        return $product;
    }

    public function store(Request $request)
    {
        if($request->get('image_name'))
        {
            $image = $request->get('image_name');
            $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            //mkdir(public_path('images/').$name, 777, true);
            \Image::make($request->get('image_name'))->resize(400, 300)->save(public_path('images/').$name);
        }
        $product = Product::create([
            'name_product' => $request->name_product,
            'description' => $request->description,
            'image_name' => $name
        ]);

        return $product;
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return '';
    }
}
