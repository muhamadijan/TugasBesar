@extends('layouts.admin')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header bg-">
            <h1>Dashboard</h1>
        </div>
        <div class="alert alert-primary" role="alert">
 Selamat datang  {{ auth()->user()->name }}
</div><br>
<h5> <i class="fa fa-edit fa-fw fa-1x" aria-hidden="true"></i> Prosedur Aplikasi TransTrack </h5><hr>
<!-- <table class="table">
  <thead>
    <tr>
      <th scope="col">Nama</th>
      <th scope="col">Email</th>
      <th scope="col">Password</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>{{ auth()->user()->name }}</td>
      <td>{{ auth()->user()->email }}</td>
        <td>{{ str_repeat('*', strlen(auth()->user()->password)) }}
</td>
    </tr>

  </tbody>
</table> -->
<center>
<img src="{{asset('/asset/img/logo.png')}}" alt="" width="450">

</center>


</div>
@endsection
