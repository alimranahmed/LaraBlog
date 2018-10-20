@extends('layouts.admin')
@section('content')
    <div class="panel panel-default no-margin-bottom">
        <div class="panel-heading">
            <strong>Welcome to laraBlog's Admin portal!</strong>
        </div>
        <div class="panel-body">
            {{--Country vs hits--}}
            <div class="col-sm-4">
                <div class="panel panel-default no-margin-bottom">
                    <div class="panel-heading">
                        <strong>Country vs Hits</strong>
                    </div>
                    <div class="panel-body">
                        <table class="table">
                            <tr>
                                <th class="text-left">#</th>
                                <th class="text-left">Country Name</th>
                                <th class="text-left">Hit Count</th>
                            </tr>
                            @php($count = 1)
                            @foreach($hitCountByCountries as $hit)
                                <tr>
                                    <td>{{$count++}}</td>
                                    <td>{{$hit->country ?? 'Unknown'}}</td>
                                    <td>{{$hit->totalHit}}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
            {{--Article by category--}}
            <div class="col-sm-4">
                <div class="panel panel-default no-margin-bottom">
                    <div class="panel-heading">
                        <strong>Article by Category</strong>
                    </div>
                    <div class="panel-body">
                        <table class="table">
                            <tr>
                                <th class="text-left">Category Name</th>
                                <th class="text-left">Number of Article</th>
                            </tr>
                            @foreach($articleCategories as $key => $category)
                                <tr><td>{{$key}}</td><td>{{count($category)}}</td></tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection