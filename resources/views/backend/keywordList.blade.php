@extends('layouts.admin')
@section('content')
    <div class="panel panel-default no-margin-bottom">
        <div class="panel-heading">
            <strong>All Keywords</strong>
        </div>
        <div class="panel-body">
            <form action="{{route('add-keyword')}}" method="post">
                {{csrf_field()}}
                <table class="table table-hover" id="keywordList">
                    <tr class="text-center">
                        <th>ID</th>
                        <th>Name</th>
                        <th>Created</th>
                        <th>Articles</th>
                        <th class="text-center">Operations</th>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="{{$errors->has('name') ? 'has-error has-feedback' : ''}}">
                            <input type="text" name="name" class="form-control" placeholder="Name*" value="{{old('name')}}">
                        </td>
                        <td>Now</td>
                        <td>0</td>
                        <td class="text-center">
                            <button type="submit" class="btn btn-success">Add</button>
                        </td>
                    </tr>
                    @foreach($keywords as $keyword)
                        <tr>
                            <td>{{$keyword->id}}</td>
                            <td>{{$keyword->name}}</td>
                            <td>{{$keyword->createdAtHuman}}</td>
                            <td>{{$keyword->articles->count()}}</td>
                            <td class="text-center">
                                <span class="fa fa-edit text-primary pointer" v-on:click="showKeywordForm({{$keyword}})"></span>&nbsp;
                                <a href="{{route('toggle-keyword-active', $keyword->id)}}">
                                    <span class="fa fa-lg {{$keyword->is_active ? 'fa-toggle-on text-success' : 'fa-toggle-off text-grey'}}"></span>
                                </a>
                                <a href="{{route('delete-keyword', $keyword->id)}}" onclick="return confirm('Are you sure to delete');">
                                    <span class="fa fa-trash text-danger"></span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </form>
            <!-- Modal -->
            <div class="modal fade" id="keyword-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Edit Keyword</h4>
                        </div>
                        <form class="form-inline" id="keyword-form" method="POST">
                            <div class="modal-body">
                                {{csrf_field()}}
                                <input type="hidden" name="_method" value="PUT">
                                <div class="form-group {{$errors->has('name') ? 'has-error has-feedback' : ''}}">
                                    <label>Name</label>
                                    <input name="name" placeholder="Name" id="name" class="form-control" value="{{old('name')}}">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('inPageJS')
    @parent
    <script type="application/javascript">
        new Vue({
            el: '#keywordList',
            data: {},
            methods: {
                showKeywordForm: function (keyword) {
                    $("#name").val(keyword.name);
                    $("#keyword-form").attr("action", "keyword/" + keyword.id);
                    $("#keyword-modal").modal("show");
                }
            }
        });
    </script>
@endsection