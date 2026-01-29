@extends('admin.layout')

@section('content')
<div class="container mt-4">
  <h3>All Customers</h3>
  <table class="table table-bordered mt-3">
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Registered At</th>
      </tr>
    </thead>
    <tbody>
      @foreach(\App\Models\User::all() as $user)
        <tr>
          <td>{{ $user->id }}</td>
          <td>{{ $user->name }}</td>
          <td>{{ $user->email }}</td>
          <td>{{ $user->created_at->format('d M Y') }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
