@extends('layouts.app')

@section('content')

    <div class="container">
        <h2>{!! $title !!}</h2>
        <br>

        {!!  $result !!}
    </div>

    <br>
    <center>
        <a href="{{ route('welcome') }}" class="btn btn-primary">Назад</a>
    </center>
    <br>

@endsection
