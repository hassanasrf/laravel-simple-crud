@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">
        <div class="panel-heading">Products</div>
        <a href="{{ asset('products/create') }}">Click here to create new Product</a>
        <div class="panel-body">
          <table class="table">
            <thead>
              <th>
                Sno.
              </th>
              <th>
                Name
              </th>
              <th>
                Price
              </th>
              <th>
                Image
              </th>
              <th>
                Edit
              </th>
              <th>
                Delete
              </th>
            </thead>
            <tbody>
              @foreach($products as $key => $product)
              <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->price }}</td>
                <td><img src="{{ asset('images') }}/{{ $product->image }}" style="width:50px"></td>
                <td>
                  <a href="{{ route('products.edit', $product->id ) }}" class="btn btn-default btn-xs">Edit</a>
                </td>
                <td>
                  <form action="{{ route('products.destroy', $product->id) }}" method="post">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button class="btn btn-xs btn-danger" onclick="myFunction()">Delete</button>
                  </form>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <marquee width="65%" direction="right" height="100px">
      Laravel Simple Product Crud with File Uploading
    </marquee>
  </div>
</div>
<script>
function myFunction() {
  alert("Sure you want to delete this...!");
}
</script>
@endsection