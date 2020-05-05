<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title >{{ config('app.name') }}</title>
        <link rel="shortcut icon" href="/images/LaravelLogo.png" />

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        {{--   Styles --}}
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/all.css') }}" rel="stylesheet">

        {{--   Scripts --}}
        {{--   Атрибут defer откладывает выполнение скрипта до тех пор, пока вся страница не будет загружена полностью.--}}
        <script src="{{ asset('js/app.js') }}" defer></script>


    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content" id="app">
                <div class="title m-b-md">
                    <img src="/images/LaravelLogo.png" id="index_logo" class="img-thumbnail"><br>
                    {{ config('app.name') }} ;)
                </div>

                @if (count($labels) == 0)

                <center>
                    <h4>Внимание! Перед использованием программы<br>Вам необходимо выполнить первоначальную загрузку перечня и курсов валют:</h4>
                    <br>
                    <div class="row">
                        <div class="col-md-6 text-left">
                            <a id="cbr-list-update" href="{{ route('cbr-list') }}" class="btn btn-danger">1. Проверить обновления перечня</a>
                        </div>
                        <div class="col-md-6 text-right">
                            <a id="cbr-base-update" href="{{ route('cbr-base') }}" class="btn btn-success">2. Проверить обновление курсов</a>
                        </div>
                    </div>
                    <br>
                    <div class="spinner-border text-danger text-center" id="cbr-list-indicator" role="status" style="display: none;">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <div class="spinner-border text-success text-center" id="cbr-base-indicator" role="status" style="display: none;">
                        <span class="sr-only">Loading...</span>
                    </div>
                </center>
                @else
                    <div class="row">
                        <div class="col-md-6 text-left"><span class="VALinfo">USD: <b>{{ $VAL1Value }}</b> </span></div>
                        <div class="col-md-6 text-right"><span class="VALinfo">EURO: <b>{{ $VAL2Value }}</b> </span></div>
                    </div>
                    <center>
                        <chartcbrinfo-component></chartcbrinfo-component>
                    </center>
                <br>
                    <center>
                        <a href="{{ route('cbr-last') }}"><h3><font color="#FB503B"><b>Полный перечень курсов валют ЦБ РФ</b></font></h3></a>
                    </center>
                <br>
                @endif

                @include('layouts.links')
                <br>
                </div>
            </div>
    <script>

        // ИНдикаторы загрузки
        window.onload = function () {

            document.getElementById("cbr-base-update").onclick = function() {
                document.getElementById("cbr-base-indicator").style.display = "block";
            };

            document.getElementById("cbr-list-update").onclick = function () {
                document.getElementById("cbr-list-indicator").style.display = "block";
            }

        }

    </script>

</body>
</html>
