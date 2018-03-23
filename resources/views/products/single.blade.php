@extends('layouts.app')

@section('content')
<div class="container">
    <div class="jumbotron">
        <h1>{{$product->title}}</h1>
        <h5>Penjual: <a href="/profile/{{$product->user->id}}">{{$product->user->name}}</a></h5><br>
        <p>{{$product->subject}}</p>

        <p><a href="/products" class="btn btn-primary btn-lg">Daftar produk</a></p>

        @if($product->isOwner())
        <div class="editDelete">
        	<p><a href="/products/{{$product->id}}/edit" class="btn btn-warning">Edit</a></p>
        </div>
        <div class="editDelete">
        	<form method="POST" action="/products/{{$product->id}}">
        		{{csrf_field()}}
      			<input type="hidden" name="_method" value="DELETE">

      			<button type="submit" class="btn btn-danger">Hapus</button>
        	</form>
        </div>
        @endif

    </div>

    <div class="col-md-6">
    @foreach($product->comments as $comment)
        <h4><a href="/profile/{{$comment->user_id}}">{{$comment->user->name}}</a></h4>
        <h4>{{$comment->subject}}</h4>
        <hr>
    @endforeach
    </div>

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="col-md-6">
    <form method="POST" action="/product-comment/{{$product->id}}"> 
        <div class="form-group">
            <label for="subject">Komentar</label>
            <textarea type="text" class= "form-control" rows= "5" cols= "80" placeholder="Tulis komentar di sini" name="subject">{{old('subject')}}</textarea>
        </div>

        {{csrf_field()}} 

        <button type="submit" class="btn btn-primary">Kirim Komentar</button>
    </form>
    </div>

</div>
@endsection
