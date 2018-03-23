@extends('layouts.app')

@section('content')
<div class="container">

    @if (session('message'))
        <div class="alert alert-success">
            <p>{{session('message')}}</p>
        </div>
    @endif

    <div class="row">
        @foreach ($products as $product)
            <div class="col-md-4">
                <div class="thumbnail">
                    <div class="caption">{{$product->title}}</div>
                    <p><a href="/products/{{$product->slug}}" class="btn btn-primary">Lihat detail</a></p>
                </div>
            </div>
        @endforeach
    </div>

</div>
@endsection
