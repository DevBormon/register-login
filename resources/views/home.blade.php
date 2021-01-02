@extends('layouts.app')

@section('content')
<div class="container">
  <h2>All Users</h2>
  <br>
  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" data-toggle="tab" href="#buyer">Buyer</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#seller">Seller</a>
    </li>
  </ul>
    
  <!-- Tab panes -->
  <div class="tab-content">
    <div id="buyer" class="container tab-pane active"><br>
      <h3>Buyer</h3>
      <table id="buyer-table" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Id</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Image</th>
            </tr>
        </thead>
        <tbody>
            @foreach($buyers as $buyer)
                <tr>
                    <td>{{$buyer->id}}</td>
                    <td>{{$buyer->first_name}}</td>
                    <td>{{$buyer->last_name}}</td>
                    <td>{{$buyer->email}}</td>
                    <td>{{$buyer->phone}}</td>
                    <td><img src="/images/{{ $buyer->image }}" height="30px" width="30px" /></td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>Id</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Image</th>
            </tr>
        </tfoot>
    </table>
    </div>
    <div id="seller" class="container tab-pane fade"><br>
      <h3>Seller</h3>
      <table id="seller-table" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Id</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Image</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sellers as $seller)
                <tr>
                    <td>{{$seller->id}}</td>
                    <td>{{$seller->first_name}}</td>
                    <td>{{$seller->last_name}}</td>
                    <td>{{$seller->email}}</td>
                    <td>{{$seller->phone}}</td>
                    <td><img src="/images/{{ $seller->image }}" height="30px" width="30px" /></td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>Id</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Image</th>
            </tr>
        </tfoot>
    </table>
    </div>
    
  </div>
</div>
<script>
$(document).ready(function() {
    $('#buyer-table').DataTable();
    $('#seller-table').DataTable();
} );
</script>
@endsection
