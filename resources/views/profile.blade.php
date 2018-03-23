@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <h1 class="text-center">Produk {{$user->name}}</h1>
           	<div class="col-md-6 col-md-offset-3">
	            <ul class="list-group">
	            	@foreach($user->products as $product)
	            	<a href="/products/{{$product->slug}}" class="list-group-item">{{$product->title}}</a>
	            	@endforeach
	            </ul>
        	</div>
    </div>
</div>
@endsection
