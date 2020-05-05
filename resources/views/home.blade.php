@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>

                <center><h2>{{ config('app.name') }}</h2></center>
                <br>

                <center>
                    <a href="{{ route('cbr-last') }}"><h3><font color="#FB503B"><b>Полный перечень курсов валют ЦБ РФ</b></font></h3></a>
                </center>
                <br>

            </div>
        </div>
    </div>
</div>
@endsection
