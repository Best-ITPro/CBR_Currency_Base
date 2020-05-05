@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="row">
        <div class="col-6 text-center">
            <div class="spinner-border text-primary text-center" id="cbr-base-indicator" role="status" style="display: none;">
                <span class="sr-only">Loading...</span>
            </div>
            <div class="spinner-border text-success text-center" id="cbr-list-indicator" role="status" style="display: none;">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

        <div class="col-6 text-right">
            <a id="cbr-base-update" href="{{ route('cbr-base') }}" class="btn btn-primary">Проверить обновления курсов</a>
            <a id="cbr-list-update" href="{{ route('cbr-list') }}" class="btn btn-success">Проверить обновление перечня</a>
        </div>
        </div>
        <br>

        <h2>{!! $title !!}</h2>

        <br>
        <chartcbrinfo-component></chartcbrinfo-component>
        <br>

        <table class="table table-hover">

            <thead>
            <tr>
                <th>№</th>
                <th>Дата</th>
                <th>Цифр. код</th>
                <th>Букв. код</th>
                <th>Номинал</th>
                <th>Валюта</th>
                <th>Курс</th>
            </tr>
            </thead>
            <tbody>
            @foreach($currency as $curr)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $curr['DateValue'] }}</td>
                    <td>{{ $curr['NumCode'] }}</td>
                    <td>{{ $curr['CharCode'] }}</td>
                    <td>{{ $curr['Nominal'] }}</td>
                    <td><a href="/cbr-last/{{  $curr['NumCode'] }}">{{ $curr['Name'] }}</a></td>
                    <td>{{ $curr['Value'] }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>

    <br><br>

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


@endsection
