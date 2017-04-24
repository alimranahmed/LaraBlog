@extends('layouts.admin')
@section('content')
    <div class="panel panel-default no-margin-bottom">
        <div class="panel-heading">
            <strong>All Categories</strong>
        </div>
        <div class="panel-body">
            <form method="post" action="{{route('add-category')}}">
                {{csrf_field()}}
                <table class="table table-hover" id="categoryList">
                    <tr class="text-center">
                        <th>ID</th>
                        <th>Name</th>
                        <th>Alias</th>
                        {{--<th>Created</th>--}}
                        <th>Articles</th>
                        <th class="text-center">Operations</th>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="{{$errors->has('name') ? 'has-error has-feedback' : ''}}">
                            <input type="text" name="name" class="form-control" placeholder="Name*" value="{{old('name')}}" required>
                        </td>
                        <td class="{{$errors->has('alias') ? 'has-error has-feedback' : ''}}">
                            <input type="text" name="alias" class="form-control" placeholder="Alias*" value="{{old('alias')}}" required>
                        </td>
                        {{--<td>Now</td>--}}
                        <td>0</td>
                        <td class="text-center">
                            <button type="submit" class="btn btn-success">Add</button>
                        </td>
                    </tr>
                    @foreach($categories as $category)
                        <tr>
                            <td>{{$category->id}}</td>
                            <td>{{$category->name}}</td>
                            <td>{{$category->alias}}</td>
                            {{--<td>{{$category->createdAtHuman}}</td>--}}
                            <td>
                                <a href="{{route('articles-by-category', $category->alias)}}" target="_blank">{{$category->articles->count()}}</a>
                            </td>
                            <td class="text-center">
                        <span class="fa fa-edit text-primary pointer"
                              v-on:click="showCategoryForm({{$category}})"></span>&nbsp;
                                <a href="{{route('toggle-category-active', $category->id)}}">
                                    <span class="fa fa-lg {{$category->is_active ? 'fa-toggle-on text-success' : 'fa-toggle-off text-grey'}}"></span>
                                </a>
                                <a href="{{route('delete-category', $category->id)}}" onclick="return confirm('Are you sure to delete')">
                                    <span class="fa fa-trash text-danger"></span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </form>
            <!-- Modal -->
            <div class="modal fade" id="category-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Edit Category</h4>
                        </div>
                        <form class="form-inline" id="category-form" method="POST">
                            <div class="modal-body">
                                {{csrf_field()}}
                                <input type="hidden" name="_method" value="PUT">
                                <div class="form-group {{$errors->has('name') ? 'has-error has-feedback' : ''}}">
                                    <label>Name</label>
                                    <input name="name" placeholder="Name" id="name" class="form-control">
                                </div>
                                <div class="form-group {{$errors->has('alias') ? 'has-error has-feedback' : ''}}">
                                    <label>Alias</label>
                                    <input name="alias" placeholder="Alias" id="alias" class="form-control">
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
            el: '#categoryList',
            data: {},
            methods: {
                showCategoryForm: function (category) {
                    $("#name").val(category.name);
                    $("#alias").val(category.alias);
                    $("#category-form").attr("action", "category/" + category.id);
                    $("#category-modal").modal("show");
                }
            }
        });
    </script>
@endsection