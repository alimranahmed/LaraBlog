@extends('layouts.admin')
@section('content')
    <div class="panel panel-default no-margin-bottom">
        <div class="panel-heading">
            <strong>Welcome to laraBlog's Admin portal!</strong>
        </div>
        <div class="panel-body">
            <div class="col-sm-4">
                <div class="panel panel-default no-margin-bottom">
                    <div class="panel-heading">
                        <strong>Country vs Hits</strong>
                    </div>
                    <div class="panel-body">
                        <table class="table">
                            <tr>
                                <th class="text-left">Country Name</th>
                                <th class="text-left">Hit Count</th>
                            </tr>
                            @foreach($hitCountries as $key => $country)
                                <tr><td>{{$key}}</td><td>{{count($country)}}</td></tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection