<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;

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
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|min:3',
            'subject' => 'required'
        ]);

        $slug = str_slug($request->title, '-');

        //Cek duplikasi slug
        if(Product::where('slug', $slug)->first() != null){
            $slug = $slug . '-' . time();
        }

        

        $user = User::find(Auth::user()->id);
        $user->products()->create([
            'title' => $request->title,
            'slug' => $slug,
            'subject' => $request->subject,
            // 'user_id' => Auth::user()->id
        ]);

        return redirect('products')->with('message', 'Produk berhasil dijual');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $product = Product::where('slug', $slug)->first();

        if(empty($product)){
            abort(404);
        }

        return view('products.single', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);

        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        if($product->isOwner())

            $product->update([
                'title' => $request->title,
                'subject' => $request->subject
            ]);

        else
            abort(403);

        return redirect('products')->with('message', 'Produk berhasil dirubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if($product->isOwner())

            $product->delete();

        else
            abort(403);

        return redirect('products')->with('message', 'Produk berhasil dihapus');
    }
}
