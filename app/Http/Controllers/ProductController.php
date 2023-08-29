<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use LVR\Colour\Hex;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return response()->view('lgs.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->view('lgs.products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator($request->all(), [
            'name' => 'required|string|min:3|max:50',
            'color' => ['required', new Hex],
            'sizes' => 'required',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'image' => 'required|image|mimes:png,jpg,jpeg|max:5000',
            'colors' => 'required|integer',
        ]);

        if (!$validator->fails()) {

            $product = new Product($request->only(['name', 'price', 'quantity']));
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $imageName = time() . '_' . rand(1, 1000000) . '.' . $file->getClientOriginalExtension();
                $image = $file->storePubliclyAs('products', $imageName, ['disk' => 'public']);
                $product->image = $image;
            }
            //colors
            $colors = [$request->input('color')];
            for ($i = 1; $i <= $request->input('colors'); $i++) {
                array_push($colors, $request->input('color_' . $i));
            }
            $product->colors = $colors;
            //sizes
            $sizes = explode(',', $request->sizes);
            $product->sizes = $sizes;

            $isSaved = $product->save();
            return response()->json([
                'message' => $isSaved ? 'Product Created Successfully!' : 'Failed to create product, Please try again.',
            ], $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
        } else {
            return response()->json([
                'message' => $validator->getMessageBag()->first(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return response()->view('lgs.products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $validator = Validator($request->all(), [
            'name' => 'required|string|min:3|max:50',
            'color' => ['required', new Hex],
            'sizes' => 'required',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:png,jpg,jpeg|max:5000',
            'colors' => 'required|integer',
        ]);

        if (!$validator->fails()) {
            $product->name = $request->input('name');
            $product->price = $request->input('price');
            $product->quantity = $request->input('quantity');
            if ($request->hasFile('image')) {
                Storage::disk('public')->delete('' . $product->image);
                $file = $request->file('image');
                $imageName = time() . '_' . rand(1, 1000000) . '.' . $file->getClientOriginalExtension();
                $newImage = $file->storePubliclyAs('products', $imageName, ['disk' => 'public']);
                $product->image = $newImage;
            }
            // Colors
            $colors = [$request->input('color')];
            for ($i = 1; $i <= $request->input('colors'); $i++) {
                array_push($colors, $request->input('color_' . $i));
            }
            $product->colors = $colors;
            // Sizes


            $sizes = explode(',', $request->sizes);

            $product->sizes = $sizes;
            
            $isSaved = $product->save();
            return response()->json([
                'message' => $isSaved ? 'Product Updated Successfully!' : 'Failed to update product, Please try again.',
            ], $isSaved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
        } else {
            return response()->json([
                'message' => $validator->getMessageBag()->first(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $isDeleted = $product->delete();
        return response()->json(
            [
                'name' => $isDeleted ? 'success' : 'error',
                'color' => $isDeleted ? 'Delete Successfully' : ' Delete Failed ! ',
                'sizes' => $isDeleted ? 'Delete Successfully' : ' Delete Failed ! ',
                'price' => $isDeleted ? 'Delete Successfully' : ' Delete Failed ! ',
                'quantity' => $isDeleted ? 'Delete Successfully' : ' Delete Failed ! '
            ],
            $isDeleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
        );
    }
}
