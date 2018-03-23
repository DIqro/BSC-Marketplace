<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductComment;

class ProductCommentController extends Controller
{

    public function store(Request $request, $id)
    {
        $this->validate($request, [
            'subject' => 'required|min:5'
        ]);

        $user = User::find(Auth::user()->id);
        $user->comments()->create([
            'subject' => $request->subject,
            'product_id' => $id
        ]);

        $product = Product::findOrFail($id);

        return redirect('products/'.$product->slug)->with('message', 'Produk berhasil dijual');
    }
}
