<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProduct;
use Session;

use App\Models\Cart;

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

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();

        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProduct $request)
    {
 
        // $extension = ".".$request->thumbnail->getClientOriginalExtension();
        if($request->has('thumbnail')) {
        $name = basename($request->thumbnail->getClientOriginalName());
        $name = $name;
        $path = $request->thumbnail->move('images', $name, 'public');
        }

        $product = Product::create([
            'title'=> $request->title,
            'description' => $request->description, 
            'thumbnail' => $path,
            'status' => $request->status,
            'featured' => ($request->featured) ? $request->featured : 0,
            'price' => $request->price,
            'discount' => ($request->discount) ? $request->discount : 0,
            'discount_price' => ($request->discount_price) ? $request->discount_price : 0,
            
        ]);

        if($product)
        {
            $product->categories()->attach($request->category_id);

            Session::flash('success', 'Product has been successfully added!');
            
            return redirect()->route('admin.product.create', compact('product'));
        }
        else {

            Session::flash('success', 'Product not added!');
            
            return redirect()->route('admin.product.create', compact('product'));
        }


        
     //   dd($request->all());

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {

        $categories = Category::with('childrens')->get();
       $products = Product::with('categories')->get();

        return view('products.all', compact('categories', 'products'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = Category::all();

        return view('admin.products.create', compact('product', 'categories'));
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

        if($request->has('thumbnail')) {

            $name = basename($request->thumbnail->getClientOriginalName());
            $name = $name;
            $path = $request->thumbnail->move('images', $name, 'public');
            $product->thumbnail = $path;
        }

            $product->title = $request->title;
            $product->description = $request->description; 
            // $product->thumbnail = $path,
            $product->status = $request->status;
            $product->featured = ($request->featured) ? $request->featured : 0;
            $product->price = $request->price;
            $product->price = ($request->discount) ? $request->discount : 0;
            $product->discount_price = ($request->discount_price) ? $request->discount_price : 0;
            
        
            $product->categories()->detach();


            if($product->save()) {

                $product->categories()->attach($request->category_id);

                Session::flash('success', 'Product has been successfully updated!');
            
                return redirect()->route('admin.product.create', compact('product'));

            }
            else {
                Session::flash('success', 'Product not deleted!');
            
                return redirect()->route('admin.product.create', compact('product'));

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
        if($product->categories()->detach() && $product->forceDelete()) {

            $product->delete();
            Session::flash('success', 'Product has been successfully deleted!');
            return redirect()->route('admin.product.index', compact('product'));
    
            }
            else {
                Session::flash('success', 'Product not deleted!');
                return redirect()->route('admin.category.index', compact('product'));
            }
    }

    public function single(Product $product) {

        return view('products.single', compact('product'));
    }

    public function addToCart(Product $product, Request $request) {

        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $qty = $request->qty ? $request->qty : 1;
        $cart = new Cart($oldCart);
        $cart->addProduct($product, $qty);

        Session::put('cart', $cart);
        return back()->with('message', "Product $product->title has been successfully added to 
        Cart");
    }

    public function cart() {

        if(!Session::has('cart')) {
            return view('products.cart');
        }

        $cart = Session::get('cart');
        return view('products.cart', compact('cart'));
    }

    public function removeProduct(Product $product) {

        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->removeProduct($product);
        Session::put('cart', $cart);

        return back()->with('message', "Product $product->title has been successfully removed from 
        Cart");

    }

    public function updateProduct(Product $product, Request $request) {

        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->updateProduct($product, $request->qty);
        Session::put('cart', $cart);

        return back()->with('message', "Product $product->title has been successfully updated in the 
        cart");

    }
}
