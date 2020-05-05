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

        <br>
        {{ $currency->links() }}
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
