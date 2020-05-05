@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <h2 class="border-bottom text-center">Standard Vue + Laravel</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <div class="btn-toolbar justify-content-center" role="toolbar" aria-label="Toolbar with buttons groups">
                    <div class="btn-group mr-2" role="group" aria-label="First group">
                        <a type="button" class="btn btn-secondary" href="#1">Example Component</a>
                        <a type="button" class="btn btn-secondary" href="#2">Vue -> Blade</a>
                        <a type="button" class="btn btn-secondary" href="#3">Ajax</a>

                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="btn-toolbar justify-content-center" role="toolbar" aria-label="Toolbar with buttons groups">
                    <div class="btn-group mr-2" role="group" aria-label="First group">
                        <a type="button" class="btn btn-secondary" href="#4">ChartLine</a>
                        <a type="button" class="btn btn-secondary" href="#5">ChartPie</a>
                        <a type="button" class="btn btn-secondary" href="#6">ChartRandom</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="owl-carousel owl-theme mt-5">
                    <div class="row m-2" data-hash="1">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body" style="min-height: 420px;">
                                    <h2 class="text-center">#1 Example Component</h2>
                                    <example-component></example-component>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row m-2" data-hash="2">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body" style="min-height: 420px;">
                                    <h2 class="text-center">#2 Vue.JS => Blade</h2>
                                    <prop-component v-bind:urldata="{{ json_encode($url_data) }}"></prop-component>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row m-2" data-hash="3">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body" style="min-height: 420px;">
                                    <h2 class="text-center">#3 Ajax => Blade</h2>
                                    <ajax-component></ajax-component>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row m-2" data-hash="4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body" style="min-height: 420px;">
                                    <h2 class="text-center">#4 Chart.js Line</h2>
                                    <chartline-component></chartline-component>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row m-2" data-hash="5">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body" style="min-height: 420px;">
                                    <h2 class="text-center">#5Chart.js Pie</h2>
                                    <chartpie-component></chartpie-component>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row m-2" data-hash="6">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body" style="min-height: 420px;">
                                    <h2 class="text-center">#6Chart.js Random</h2>
                                    <chartrandom-component></chartrandom-component>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
