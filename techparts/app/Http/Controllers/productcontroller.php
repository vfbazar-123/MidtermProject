<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class productcontroller extends Controller
{
    public function index(Request $request){
$search = $request->input('search');
$products = Product::query()
->when($search, function ($query, $search) {
$query->where('name', 'like', "%{$search}%")
->orWhere('cat', 'like', "%{$search}%");
})
->orderBy('created_at', 'desc')
->get();
return view('home', compact('products', 'search'));
}

    /**
     * Display product list, optionally filtered by search query.
     */
    public function product_manage(Request $request)
    {
        $search = $request->query('search');

        $products = Product::when($search, function ($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%');
        })->get();

        return view('products', compact('products', 'search'));
    }
public function product_create(){
$newProductId =$this->generateproductid();
return view('add_product', compact('newProductId'));
}

public function product_save(Request $request){
// Validate input
$request->validate([
'product_id'=>'required|string|max:15',
'name'=>'required|string|max:255',
'cat'=>'required|string|max:255',
'qty'=>'required|integer|min:0',
'price'=>'required|numeric|min:0',
'picture_id'=>'required|image|mimes:jpeg,png,jpg|max:2048'
]);
// Handle picture upload
$fileName = null;
if($request->hasFile('picture_id')){
$file = $request->file('picture_id');
$fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
$filePath = 'product_image/' . $fileName;
$file->storeAs('product_image',$fileName,'public');
}
        // Save to database
        Product::create([
            'product_id' => $request->product_id,
            'name' => $request->name,
            'cat' => $request->cat,
            'qty' => $request->qty,
            'price' => $request->price,
            'picture_id' => $filePath,
        ]);

        return redirect()->route('product.create')->with('success', 'product added successfully');
}
private function generateproductid() {
        $latestProduct = Product::orderBy('created_at', 'desc')->first();
if(!$latestProduct){
return 'PROD001';
}
$latestNumber = intval(substr($latestProduct->product_id,4));
$nextIdNumber = $latestNumber + 1;
return 'PROD' . str_pad($nextIdNumber,3,'0',STR_PAD_LEFT);
}

    /**
     * Show the form for editing the specified product.
     */
    public function edit($product_id)
    {
        $product = Product::where('product_id', $product_id)->firstOrFail();
        return view('edit_product', compact('product'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, $product_id)
    {
        $product = Product::where('product_id', $product_id)->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'cat' => 'required|string|max:255',
            'qty' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'picture_id' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Handle picture upload if present
        if ($request->hasFile('picture_id')) {
            $file = $request->file('picture_id');
            $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $filePath = 'product_image/' . $fileName;
            $file->storeAs('product_image', $fileName, 'public');

            // delete old picture if exists
            if ($product->picture_id && Storage::disk('public')->exists($product->picture_id)) {
                Storage::disk('public')->delete($product->picture_id);
            }

            $product->picture_id = $filePath;
        }

        $product->name = $request->name;
        $product->cat = $request->cat;
        $product->qty = $request->qty;
        $product->price = $request->price;
        $product->save();

        return redirect()->route('product.list')->with('success', 'Product updated');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy($product_id)
    {
        $product = Product::where('product_id', $product_id)->firstOrFail();

        // delete picture if exists
        if ($product->picture_id && Storage::disk('public')->exists($product->picture_id)) {
            Storage::disk('public')->delete($product->picture_id);
        }

        $product->delete();

        return redirect()->route('product.list')->with('success', 'Product deleted');
    }

    /**
     * Generate and download a PDF of the products list.
     * Uses barryvdh/laravel-dompdf if available; falls back to redirect with message if not.
     */
    public function downloadPDF(Request $request)
    {
        // Generate a PDF matching the current product list (supports optional "search" query)
        try {
            $search = $request->query('search');

            $products = Product::when($search, function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('cat', 'like', '%' . $search . '%');
            })->orderBy('created_at', 'desc')->get();

            $pdf = Pdf::loadView('pdf', compact('products'))->setPaper('letter', 'portrait');
            return $pdf->download('Product_List.pdf');
        } catch (\Throwable $e) {
            return redirect()->route('product.list')->with('error', 'PDF export is not available on this installation.');
        }
    }
}