@extends('layouts.app')

@section('content')
<div class="row">
  <div class="offset-md-10 col-md-2">
    <a href="{{ route('orders.create') }}" class="btn btn-primary btn-block">+ New Order</a>
    <a href="{{ route('orders.index') }}" class="btn btn-primary btn-block">Orders List</a>
  </div>
</div>
<br>
<div class="row">
  <div class="col-md-12">
    <table class="table">
      <thead class="thead-dark">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Title</th>
          <th scope="col">Description</th>
          <th scope="col">Cost</th>
          <th scope="col">Contratto</th>
          <th scope="col" colspan="2" class="text-center">Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($orders as $order)
          <tr>
            <th scope="row">{{ $order->id }}</th>
            <td>{{ $order->title }}</td>
            <td>{{ $order->description }}</td>
            <td>{{ number_format($order->cost,2)}} €</td>
            <td>{{!empty($order->contracts)?$order->contracts->title : "Nessun Contratto"}}</td>
            <td class="text-center"><a class="btn btn-primary btn-sm" href="{{ route('orders.restore', $order) }}">RESTORE</a></td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    {{ $orders->links() }}
  </div>
</div>

@stop