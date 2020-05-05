@extends('layouts.app')

@section('content')
<script>
    window.NumCode ="{{ $NumCode }}";
</script>

    <div class="container">
        <h2>{!! $title !!}</h2>

        <br>
        <chartcbrline-component></chartcbrline-component>
        <br>

        <table class="table table-hover">

            <thead>
            <tr>
                <th>№</th>
                <th>Номинал</th>
                <th>Дата</th>
                <th>Курс</th>
            </tr>
            </thead>
            <tbody>

            @foreach($currency as $curr)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $curr['Nominal'] }}</td>
                    <td>{{ $curr['DateValue'] }}</td>
                    <td>{{ $curr['Value'] }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <br>
        {{ $currency->links() }}

        <center>
            <a href="{{ route('cbr-last') }}" class="btn btn-primary">Назад к списку валют</a>
        </center>
        <br>
    </div>

    <br><br>

@endsection
<script>
    // import ChartcbrlineComponent from "../../js/components/ChartcbrlineComponent";
    // export default {
    //     components: {ChartcbrlineComponent}
    // }
</script>
